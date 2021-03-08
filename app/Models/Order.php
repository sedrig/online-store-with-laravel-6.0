<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    
    public function products(){
        return $this->belongsToMany(Product::class)->withPivot('count')->withTimestamps();
    }

   /* public function user(){
        return $this->belongsTo(User::class);
    }*/

    public function scopeActive($query){
        return $query->where('status','1');
    }

    public function calculateFullPrice(){
        $sum=0;
        foreach($this->products()->withTrashed()->get() as $product){
            $sum+=$product->getPriceForCount();
        }
        return $sum;
    }

    public static function eraseOrderSum(){
        session()->forget('full_order_sum');
    }

    public static function  changeFullSum($changeSum){
        $sum=self::getFullPrice()+$changeSum;
        session (['full_order_sum'=>$sum]);
    }

    public static function getFullPrice(){
        return session('full_order_sum', 0);
    }

    public function saveOrder($name,$phone,$email){
        if($this->status==0){
        $this->name=$name;
        $this->phone=$phone;
        $this->email=$email;
        $this->status=1;
        $this->save();
        session()->forget('orderId');
        return true;
    }else{
        return false;
    }
    }
}
