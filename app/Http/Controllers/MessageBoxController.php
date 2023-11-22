<?php

namespace App\Http\Controllers;

use App\Models\ChatInfo;
use App\Models\Contact;
use App\Models\CustomerContact;
use App\Models\MessageStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MessageBoxController extends Controller
{
    //MESSAGEBOX LIST
    public function listPage()
    {
        $message = Contact::whereNot('user_id', Auth::user()->id)->get();
        //total message count
        $countMessage = CustomerContact::groupBy('user_id')
            ->select('user_id', DB::raw('count(*) as count'))
            ->orderBy('user_id', 'desc')
            ->where('status', 0)
            ->get();
        $message = MessageStatus::where('status', false)
            ->where('user_id', Auth::user()->id)->get();
        return view('admin.message.listPage', compact('message', 'countMessage', 'message'));
    }

    //SELECT CHAT
    public function selectChat()
    {
        $message = MessageStatus::where('status', false)
            ->where('user_id', Auth::user()->id)->get();
        $groupName = ChatInfo::get();

        $customerMessage = CustomerContact::select('customer_contacts.*', 'customers.image as image')
            ->leftJoin('customers', 'customers.id', '=', 'customer_contacts.user_id')
            ->whereIn('customer_contacts.id', function ($query) {
                $query->selectRaw('MAX(id)')
                    ->from('customer_contacts')
                    ->groupBy('user_id');
            })
            ->orderBy('customer_contacts.id', 'desc')
            ->get();

        $countMessage = CustomerContact::groupBy('user_id')
            ->select('user_id', DB::raw('count(*) as count'))
            ->orderBy('user_id', 'desc')
            ->where('status', 0)
            ->get();

        $message = MessageStatus::where('status', false)
            ->where('user_id', Auth::user()->id)->get();
        return view('admin.message.selectChat', compact('message', 'groupName', 'customerMessage', 'countMessage', 'message'));
    }

    //ADMINS CHAT PAGE
    public function adminsChat()
    {
        MessageStatus::where('user_id', Auth::user()->id)->update([
            'status' => true,
        ]);

        $message = Contact::whereNot('user_id', Auth::user()->id)->get();
        $dataStatus = Contact::where('user_id', Auth::user()->id)
            ->first();
        if ($dataStatus && $dataStatus->show_status) {
            $datas = Contact::select('contacts.*', 'users.name as user_name', 'users.image as user_image')
                ->leftJoin('users', 'users.id', 'contacts.user_id')
                ->where('reset_status', false)

                ->orderBy('created_at', 'asc')->get();
        } else {
            $datas = Contact::select('contacts.*', 'users.name as user_name', 'users.image as user_image')
                ->leftJoin('users', 'users.id', 'contacts.user_id')

                ->orderBy('created_at', 'asc')->get();
        }
        $users = User::get();
        $status = Contact::where('user_id', Auth::user()->id)->first();

        $groupName = ChatInfo::get();

        $customerMessage = CustomerContact::select('customer_contacts.*', 'customers.image as image')
            ->leftJoin('customers', 'customers.id', '=', 'customer_contacts.user_id')
            ->whereIn('customer_contacts.id', function ($query) {
                $query->selectRaw('MAX(id)')
                    ->from('customer_contacts')
                    ->groupBy('user_id');
            })
            ->orderBy('customer_contacts.id', 'desc')
            ->get();

        $countMessage = CustomerContact::groupBy('user_id')
            ->select('user_id', DB::raw('count(*) as count'))
            ->orderBy('user_id', 'desc')
            ->where('status', 0)
            ->get();

        $message = MessageStatus::where('status', false)
            ->where('user_id', Auth::user()->id)->get();

        return view('admin.message.adminChat', compact('users', 'datas', 'status', 'message', 'groupName', 'customerMessage', 'countMessage', 'message'));
    }

    //ADMIN DELETE CHAT
    public function deleteChat($id)
    {
        Contact::where('user_id', $id)->update([
            'delete_status' => true,
            'show_status' => true,
        ]);
        Contact::select('*')->update(['reset_status' => true]);

        return redirect()->route('select#chat');
    }

    //SENDING MESSAGES TO OTHER ADMINS
    public function replyMessage(Request $request)
    {

        if ($request->message !== null || $request->image !== null) {
            $data = [
                'user_id' => $request->userId,
                'message' => $request->message,

            ];
            if ($request->file('image')) {
                $image = uniqid() . $request->file('image')->getClientOriginalName();
                $request->file('image')->storeAs('public/' . $image);
                $data['image'] = $image;
            }
            Contact::where('user_id', Auth::user()->id)->update([
                'delete_status' => false,
            ]);
            Contact::create($data);

            //inserting data into message_status table to check if the message is seen by different users or not
            $message = Contact::where('user_id', Auth::user()->id)->get();
            foreach ($message as $row) {
                $row = $row->id;
            }
            $users = User::get();
            foreach ($users as $user) {
                $user = $user->id;
                MessageStatus::create([
                    'user_id' => $user,
                    'message_id' => $row,
                    'status' => false,
                ]);
            }

        }
        return back();

    }

    //DELETING MY MESSAGES
    public function deleteMessage($id)
    {
        $contact = Contact::where('id', $id)->first();

        if ($contact) {
            if ($contact->image != null) {
                Contact::where('id', $id)->update([
                    'message' => null,
                ]);
            } else {
                Contact::select('image')->where('id', $id)->delete();
            }
            MessageStatus::where('message_id', $contact->id)->delete();
            return back();
        }

        return back();

    }

    //DELETING THE IMAGE I SENT
    public function deleteImage($id)
    {
        $data = Contact::where('id', $id)->first();

        //deleting img in file
        if (Storage::exists('public/' . $data->image)) {
            Storage::delete('public/' . $data->image);
        }
        //deleting img in db
        $contact = Contact::where('id', $id)->first();
        if ($contact->message != null) {
            Contact::where('id', $id)->update(['image' => null]);
        } else {
            Contact::select('image')->where('id', $id)->delete();
            MessageStatus::where('message_id', $contact->id)->delete();
        }

        return back();
    }

}
