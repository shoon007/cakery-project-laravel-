<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CustomerContact;
use App\Models\MessageStatus;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    //POST CREATE PAGE
    public function createPage()
    {
        $categories = Category::select('id', 'name')->get();
        //total message count
        $countMessage = CustomerContact::groupBy('user_id')
            ->select('user_id', DB::raw('count(*) as count'))
            ->orderBy('user_id', 'desc')
            ->where('status', 0)
            ->get();
        $message = MessageStatus::where('status', false)
            ->where('user_id', Auth::user()->id)->get();
        return view('admin.post.create', compact('categories', 'countMessage', 'message'));
    }

    //POST CREATE
    public function create(Request $request)
    {
        $this->postValidationCheck($request, 'create');
        $data = $this->postData($request);
        //create unique img name
        $fileName = uniqid() . $request->file('image')->getClientOriginalName();
        // img saving in public file & database
        $request->file('image')->storeAs('public/' . $fileName);
        $data['image'] = $fileName;
        Product::create($data);
        return redirect()->route('product#listPage')->with(['createSuccess' => 'The product is created!']);
    }

    //POST LIST
    public function listPage()
    {
        $products = Product::select('products.*', 'categories.name as category_name')
            ->when(request('key'), function ($query) {
                $query->orWhere('products.name', 'like', '%' . request('key') . '%')
                    ->orWhere('categories.name', 'like', '%' . request('key') . '%')
                    ->orWhere('products.price', 'like', '%' . request('key') . '%')
                    ->orWhere('products.view_count', 'like', '%' . request('key') . '%');
            })
            ->leftJoin('categories', 'products.category_id', 'categories.id')
            ->orderBy('products.id', 'desc')
            ->paginate(3);
        $products->appends(request()->all());

        //total message count
        $countMessage = CustomerContact::groupBy('user_id')
            ->select('user_id', DB::raw('count(*) as count'))
            ->orderBy('user_id', 'desc')
            ->where('status', 0)
            ->get();
        $message = MessageStatus::where('status', false)
            ->where('user_id', Auth::user()->id)->get();
        return view('admin.post.list', compact('products', 'countMessage', 'message'));

    }

    //POST DELETE
    public function delete($id)
    {
        Product::where('id', $id)->delete();
        return back();
    }

    //POST EDIT PAGE
    public function editPage($id)
    {
        $product = Product::where('id', $id)->first();
        $categories = Category::get();
        //total message count
        $countMessage = CustomerContact::groupBy('user_id')
            ->select('user_id', DB::raw('count(*) as count'))
            ->orderBy('user_id', 'desc')
            ->where('status', 0)
            ->get();
        $message = MessageStatus::where('status', false)
            ->where('user_id', Auth::user()->id)->get();
        return view('admin.post.edit', compact('product', 'categories', 'countMessage', 'message'));

    }

    //POST UPDATE
    public function update(Request $request)
    {
        //dd($request->toArray());
        $this->postValidationCheck($request, 'update');
        $postData = $this->postData($request);
        if ($request->file('image')) {
            $product = Product::where('id', $request->id)->first();
            Storage::delete('public/' . $product->image);
            $fileName = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public/' . $fileName);
            $postData['image'] = $fileName;
        }

        Product::where('id', $request->id)->update($postData);
        return redirect()->route('product#listPage')->with(['updateSuccess' => 'The product is updated!']);
    }

    //POST DETAILS
    public function details($id)
    {
        $product = Product::select('products.*', 'categories.name as category_name')
            ->leftJoin('categories', 'products.category_id', 'categories.id')
            ->where('products.id', $id)->first();
        //total message count
        $countMessage = CustomerContact::groupBy('user_id')
            ->select('user_id', DB::raw('count(*) as count'))
            ->orderBy('user_id', 'desc')
            ->where('status', 0)
            ->get();
        $message = MessageStatus::where('status', false)
            ->where('user_id', Auth::user()->id)->get();
        return view('admin.post.details', compact('product', 'countMessage', 'message'));

    }

    //post data
    private function postData($request)
    {
        return [
            'category_id' => $request->category,
            'name' => $request->postName,
            'description' => $request->description,
            'price' => $request->price,
        ];
    }

    //post validation check
    private function postValidationCheck($request, $status)
    {
        $validationRules = [
            'postName' => 'required|min:5|unique:products,name,' . $request->id,
            'category' => 'required',
            'description' => 'required',
            'price' => 'required',
        ];

        $validationRules['image'] = $status == 'create' ? 'required|mimes:png,jpg,jpeg,webp|file' : 'mimes:png,jpg,jpeg,webp|file';
        Validator::make($request->all(), $validationRules)->validate();
    }
}
