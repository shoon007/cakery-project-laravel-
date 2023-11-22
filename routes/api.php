<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\customer\AuthController;
use App\Http\Controllers\customer\PostController;
use App\Http\Controllers\customer\CategoryController;
use App\Http\Controllers\customer\CustomerController;
use App\Http\Controllers\customer\ActionLogsController;


Route::post('customer/login',[AuthController::class,'login']);
Route::post('customer/register',[AuthController::class,'register']);


//post(product)
 Route::get('getAllPost',[PostController::class,'getAllPost']);
//best seller product
Route::get('bestSeller/cakes',[PostController::class,'bestSeller']);
 //post details
Route::post('post/details',[PostController::class,'postDetails']);



//category
Route::get('getAllCategory',[CategoryController::class,'getAllCategory']);
//category search
Route::post('category/search',[CategoryController::class,'categorySearch']);
//product search
Route::post('product/search',[CategoryController::class,'productSearch']);


//account edit
Route::post('account/edit',[CustomerController::class,'accountEdit']);
//account update
Route::post('account/update/{id}/{name}/{email}',[CustomerController::class,'accountUpdate']);
//delete profile
Route::post('profile/delete',[CustomerController::class,'deleteImg']);
//change password
Route::post('changePassword',[CustomerController::class,'changePassword']);
//customer check info
Route::post('check/customerInfo',[CustomerController::class,'customerCheckInfo']);
//customer contact
Route::post('customer/contact',[CustomerController::class,'customerContact']);
//action log for view count
Route::post('post/actionLog',[ActionLogsController::class,'setActionLog']);

//add like
Route::post('add/like',[ActionLogsController::class,'addLike']);
//remove like
Route::post('remove/like',[ActionLogsController::class,'removeLike']);
//post like
Route::post('post/like',[ActionLogsController::class,'postLike']);
//like count
Route::post('like/count',[ActionLogsController::class,'likeCount']);
//all post like
Route::post('all/postLike',[ActionLogsController::class,'allPostLike']);
//order
Route::post('product/order',[ActionLogsController::class,'productOrder']);
//cart count
Route::post('cart/count',[ActionLogsController::class,'cartCount']);
//order list
Route::post('cart/lists',[ActionLogsController::class,'cartLists']);
//product quantity(increase & decrease)
Route::post('product/quantity',[ActionLogsController::class,'productQuantity']);
//product delete (by row)
Route::post('product/delete',[ActionLogsController::class,'productDelete']);
//clear cart
Route::post('clear/cart',[ActionLogsController::class,'clearCart']);
//cart list
Route::post('cartList/checkout',[ActionLogsController::class,'checkout']);
//cart history
Route::post('cart/history',[ActionLogsController::class,'cartHistory']);
