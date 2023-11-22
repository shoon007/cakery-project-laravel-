<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CustomerContact;
use App\Models\MessageStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    //CREATE CATEGORY PAGE
    public function createPage()
    {
        //total message count
        $countMessage = CustomerContact::groupBy('user_id')
            ->select('user_id', DB::raw('count(*) as count'))
            ->orderBy('user_id', 'desc')
            ->where('status', 0)
            ->get();
        $message = MessageStatus::where('status', false)
            ->where('user_id', Auth::user()->id)->get();
        return view('admin.category.create', compact('countMessage', 'message'));
    }

    //CATEGORY CREATE
    public function create(Request $request)
    {
        $this->categoryValidationCheck($request);
        $data = $this->categoryData($request);
        Category::create($data);
        return redirect()->route('category#listPage')->with(['createSuccess' => 'The category is created!']);
    }

    //CATEGORY LIST PAGE
    public function listPage()
    {
        $categories = Category::when(request('key'), function ($query) {
            $query->orWhere('name', 'like', '%' . request('key') . '%')
                ->orWhere('id', 'like', '%' . request('key') . '%');
        })
            ->orderBy('id', 'desc')
            ->paginate(5);
        $categories->appends(request()->all());
        //total message count
        $countMessage = CustomerContact::groupBy('user_id')
            ->select('user_id', DB::raw('count(*) as count'))
            ->orderBy('user_id', 'desc')
            ->where('status', 0)
            ->get();
        $message = MessageStatus::where('status', false)
            ->where('user_id', Auth::user()->id)->get();
        return view('admin.category.list', compact('categories', 'countMessage', 'message'));
    }

    //DELETE CATEGORY
    public function delete($id)
    {
        Category::where('id', $id)->delete();
        return back();
    }

    //UPDATE CATEGORY PAGE
    public function updatePage($id)
    {
        $category = Category::where('id', $id)->first();
        //total message count
        $countMessage = CustomerContact::groupBy('user_id')
            ->select('user_id', DB::raw('count(*) as count'))
            ->orderBy('user_id', 'desc')
            ->where('status', 0)
            ->get();
        $message = MessageStatus::where('status', false)
            ->where('user_id', Auth::user()->id)->get();
        return view('admin.category.update', compact('category', 'countMessage', 'message'));
    }

    //UPDATE CATEGORY
    public function update(Request $request)
    {
        $this->categoryValidationCheck($request);
        $data = $this->categoryData($request);
        Category::where('id', $request->categoryId)->update($data);
        return redirect()->route("category#listPage")->with(['updateSuccess' => 'The category is updated!']);
    }

    //category data
    private function categoryData($request)
    {
        return [
            'name' => $request->categoryName,
        ];
    }

    //category create validation
    private function categoryValidationCheck($request)
    {
        Validator::make($request->all(), [
            'categoryName' => 'required|min:5|unique:categories,name,' . $request->categoryId,
        ])->validate();
    }
}
