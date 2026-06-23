<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminProductController extends Controller
{
    public function index()
    {
        $viewData = [];
        $viewData["title"] = "Admin Page - Products - Online Store";
        $viewData["products"] = Product::all();

        return view('admin.product.index')->with("viewData", $viewData);
    }

    public function store(Request $request)
    {
        Product::validate($request);

        $newProduct = new Product();

        $newProduct->setName($request->input('name'));
        $newProduct->setDescription($request->input('description'));
        $newProduct->setPrice($request->input('price'));

        if ($request->hasFile('image')) {

            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();

            $request->file('image')->storeAs(
                'products',
                $imageName,
                'public'
            );

            $newProduct->setImage('products/' . $imageName);
        }

        $newProduct->save();

        return back();
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);

        if (
            $product->getImage() &&
            Storage::disk('public')->exists($product->getImage())
        ) {
            Storage::disk('public')->delete($product->getImage());
        }

        $product->delete();

        return back();
    }

    public function edit($id)
    {
        $viewData = [];
        $viewData["title"] = "Edit Product - Online Store";
        $viewData["product"] = Product::findOrFail($id);

        return view('admin.product.edit')->with("viewData", $viewData);
    }

    public function update(Request $request, $id)
    {
        Product::validate($request);

        $product = Product::findOrFail($id);

        $product->setName($request->input('name'));
        $product->setDescription($request->input('description'));
        $product->setPrice($request->input('price'));

        if ($request->hasFile('image')) {

            if (
                $product->getImage() &&
                Storage::disk('public')->exists($product->getImage())
            ) {
                Storage::disk('public')->delete($product->getImage());
            }

            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();

            $request->file('image')->storeAs(
                'products',
                $imageName,
                'public'
            );

            $product->setImage('products/' . $imageName);
        }

        $product->save();

        return redirect()->route('admin.product.index');
    }
}