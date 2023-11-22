<?php

use App\Http\Controllers\ActionLogsController;
use App\Models\Contact;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChatInfoController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MessageBoxController;
use App\Models\Customer;
use App\Models\CustomerContact;
use PHPUnit\Framework\Attributes\PostCondition;

//error page
Route::get('404error',[AuthController::class,'errorPage'])->name('errorPage');

//logout
Route::get('/logout',[AuthController::class,'logout']);



//auth for login & register page
Route::middleware([
    'admin_auth'
])->group(function(){
    Route::redirect('/','loginPage');
    Route::get('/registerPage',[AuthController::class,'registerPage'])->name('auth#registerPage');
    Route::get('/loginPage',[AuthController::class,'loginPage'])->name('auth#loginPage');
});



//here using auth middleware & admin middleware for security
Route::middleware([
    'auth'
])->group(function () {
    //ADMIN INFORMATION
    Route::group(['prefix' => 'admin', 'middleware' => 'admin_auth'], function () {
    //admin dashboard
    Route::get('dashboard',[AdminController::class,'dashboard'])->name('admin#dashboard');
    Route::get('layouts/master',[AdminController::class,'layouts'])->name('admin#masterLayout');
    //admin changePassword
    Route::get('changePasswordPage',[AdminController::class,'changePasswordPage'])->name('admin#changePasswordPage');
    Route::post('changePassword',[AdminController::class,'changePassword'])->name('admin#changePassword');
    //admin account
    Route::get('detailsPage',[AdminController::class,'detailsPage'])->name('admin#detailsPage');
    Route::get('editPage',[AdminController::class,'editPage'])->name('admin#editPage');
    Route::post('update',[AdminController::class,'update'])->name('admin#update');
    //admin lists
    Route::get('list',[AdminController::class,'adminList'])->name('admin#list');
    //admin account delete
    Route::get('account/delete/{id}',[AdminController::class,'accountDelete'])->name('admin#delete');
    //all admins account details
    Route::get('accounts/detail/{id}',[AdminController::class,'accountDetail'])->name("admin#accountDetail");
    //change order status from admin
    Route::get('order/status/change',[AdminController::class,'orderStatus'])->name('order#statusChange');

});

    //CATEGORY
    Route::group(['prefix' => 'category', 'middleware' => 'admin_auth'], function () {
    //create category
    Route::get('createPage',[CategoryController::class,'createPage'])->name('category#createPage');
    Route::post('create',[CategoryController::class,'create'])->name('category#create');
    //category list
    Route::get('listPage',[CategoryController::class,'listPage'])->name('category#listPage');
    //delete category
    Route::get('delete/{id}',[CategoryController::class,'delete'])->name('category#delete');
    //update category page
    Route::get('updatePage/{id}',[CategoryController::class,'updatePage'])->name('category#updatePage');
    //update category
    Route::post('update',[CategoryController::class,'update'])->name('category#update');
    });



    //PRODUCT
        Route::group(['prefix' => 'product', 'middleware' => 'admin_auth'], function () {
        //create product
        Route::get('createPage',[ProductController::class,'createPage'])->name('product#createPage');
        Route::post('create',[ProductController::class,'create'])->name('product#create');

        // product list
        Route::get('listPage',[ProductController::class,'listPage'])->name('product#listPage');
        //product delete
        Route::get('delete/{id}',[ProductController::class,'delete'])->name('product#delete');
        //product details page
        Route::get('details/{id}',[ProductController::class,'details'])->name('product#details');
        //product edit page
        Route::get('editPage/{id}',[ProductController::class,'editPage'])->name('product#editPage');
        //product update
        Route::post('update',[ProductController::class,'update'])->name('product#update');

    });

    // MESSAGE BOX
    Route::group(['prefix' => 'message', 'middleware' => 'admin_auth'], function () {
    //admin chatbox page
    Route::get('listPage',[MessageBoxController::class,'listPage'])->name('message#listPage');
    Route::get('admins/chat',[MessageBoxController::class,'adminsChat'])->name('admins#chat');
    //message functionality
    Route::post('reply',[MessageBoxController::class,'replyMessage'])->name('message#reply');
    Route::get('delete/{id}',[MessageBoxController::class,'deleteMessage'])->name('message#delete');
    Route::get('imgDelete/{id}',[MessageBoxController::class,'deleteImage'])->name('image#delete');
    });



    //select chat
    Route::get('select/chat',[MessageBoxController::class,'selectChat'])->name('select#chat');
    //delete chat
    Route::get('delete/chat/{id}',[MessageBoxController::class,'deleteChat'])->name('delete#chat');
    //ADMIN CHAT INFORMATIONS
    Route::get('info/chat',[ChatInfoController::class,'infoChat'])->name('info#chat');
    Route::post('save/title',[ChatInfoController::class,'saveTitle'])->name('save#titleChat');
    Route::post('upload/img',[ChatInfoController::class,'uploadImg'])->name('chat#uploadImg');



    //CUSTOMER
    //customer list
    Route::group(['prefix' => 'customer', 'middleware' => 'admin_auth'], function () {
    Route::get('list',[CustomerController::class,'customerList'])->name('customer#list');
    //customer order list
    Route::get('order/list/{id}/{orderCode}',[CustomerController::class,'orderList'])->name('customer#orderList');
    //customer contact page(customer messages)
    Route::get('contact/page/{id}',[CustomerController::class,'contactPage'])->name('customer#contact');
    Route::get('message/delete/{id}',[CustomerController::class,'deleteMessage'])->name('customer#deleteMessage');
    Route::get('message/view/{id}',[CustomerController::class,'messageView'])->name('customer#viewMessage');
});


    // VIEWCOUNT/LIKE/INCOME
    //customer list
    Route::group(['prefix' => 'actionLogs', 'middleware' => 'admin_auth'], function () {
    //view count list
    Route::get('viewCount/list',[ActionLogsController::class,'viewCount'])->name('viewCount#list');
    //like count list
    Route::get('likeCount/list',[ActionLogsController::class,'likeCount'])->name('likeCount#list');
    //income list
    Route::get('income/list',[ActionLogsController::class,'incomeList'])->name('income#list');

});





});
