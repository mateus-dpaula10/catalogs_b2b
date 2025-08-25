<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Company;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(User $user) {
        return view ('products.index', compact('user'));
    }

    public function create() {
        $companies = Company::where('id', $user->company_id)->get();
        $categories = Category::where('company_id', $user->company_id)->get();
        $brands = Brand::where('company_id', $user->company_id)->get();

        return view ('products.create', compact('user', 'companies', 'categories', 'brands'));
    }

    public function store(Request $request) {
        $user = auth()->user();

        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'price'       => 'required|numeric|min:0',
            'company_id'  => 'required|exists:companies,id',
            'images'      => 'required|array|max:10',
            'images.*'    => 'image|mimes:jpg,jpeg,png|max:5120'
        ]);

        if ($request->filled('new_category')) {
            $category = Category::create([
                'name'       => $request->new_category,
                'company_id' => $request->company_id
            ]);
            $request->merge(['category_id' => $category->id]);
        }

        if (!$request->filled('category_id')) {
            return back()->withErrors(['category_id' => 'Selecione ou crie uma categoria.']);
        }

        if ($request->filled('new_brand')) {
            $brand = Brand::create([
                'name'       => $request->new_brand,
                'company_id' => $request->company_id
            ]);
            $request->merge(['brand_id' => $brand->id]);
        }        

        if (!$request->filled('brand_id')) {
            return back()->withErrors(['brand_id' => 'Selecione ou crie uma marca.']);
        }

        $product = Product::create($request->only([
            'name', 'description', 'price', 'company_id', 'category_id', 'brand_id'
        ]));

        foreach ($request->file('images') as $index => $image) {
            $path = $image->store('products', 'public');

            $product->images()->create([
                'path'    => $path,
                'is_main' => $index === 0
            ]);
        }

        return redirect()->back()->with('success', 'Produto cadastrado com sucesso!');
    }
}
