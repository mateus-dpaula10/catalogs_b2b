<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Company;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index(User $user) {
        $products = Product::with('category', 'brand', 'images', 'mainImage')->where('company_id', $user->company_id)->get();

        return view ('products.index', compact('user', 'products'));
    }

    public function create(User $user) {
        $companies = Company::where('id', $user->company_id)->get();
        $categories = Category::where('company_id', $user->company_id)->get();
        $brands = Brand::where('company_id', $user->company_id)->get();

        return view ('products.create', compact('user', 'companies', 'categories', 'brands'));
    }

    public function store(Request $request) {
        $user = auth()->user();

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products')->where(function ($query) use ($request) {
                    return $query->where('company_id', $request->company_id);
                }), 
            ],
            'description' => 'required|string',
            'price'       => 'required|numeric|min:0',
            'company_id'  => 'required|exists:companies,id',
            'images'      => 'required|array|max:10',
            'images.*'    => 'image|mimes:jpg,jpeg,png|max:5120'
        ], [
            'name.required'        => 'O nome do produto é obrigatório.',
            'name.max'             => 'O nome do produto não pode ter mais que 255 caracteres.',        
            'name.unique'          => 'Já existe um produto com este nome nesta empresa.',    
            'description.required' => 'A descrição é obrigatória.',
            'price.required'       => 'O preço é obrigatório.',
            'price.numeric'        => 'O preço deve ser um número.',
            'price.min'            => 'O preço não pode ser negativo.',
            'company_id.required'  => 'A empresa é obrigatória.',
            'company_id.exists'    => 'A empresa selecionada não existe.',
            'images.required'      => 'É necessário enviar pelo menos uma imagem.',
            'images.array'         => 'As imagens devem estar em formato de lista.',
            'images.max'           => 'Você pode enviar no máximo 10 imagens.',            
            'images.*.image'       => 'Cada arquivo deve ser uma imagem.',
            'images.*.mimes'       => 'As imagens devem estar nos formatos: jpg, jpeg ou png.',
            'images.*.max'         => 'Cada imagem deve ter no máximo 5MB.'
        ]);

        if ($request->filled('new_category')) {
            $category = Category::firstOrCreate(
                [
                    'name' => $request->new_category,
                    'company_id' => $request->company_id,
                ]
            );
            $categoryId = $category->id;
        } else {
            $categoryId = $request->category_id;
        }

        if (!$categoryId) {
            return back()->withErrors(['category_id' => 'Selecione ou crie uma categoria.']);
        }

        if ($request->filled('new_brand')) {
            $brand = Brand::firstOrCreate(
                [
                    'name' => $request->new_brand,
                    'company_id' => $request->company_id,
                ]
            );
            $brandId = $brand->id;
        } else {
            $brandId = $request->brand_id;
        }    

        if (!$brandId) {
            return back()->withErrors(['brand_id' => 'Selecione ou crie uma marca.']);
        }

        $product = Product::create([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'company_id'  => $request->company_id,
            'category_id' => $categoryId,
            'brand_id'    => $brandId,
        ]);

        foreach ($request->file('images') as $index => $image) {
            $path = $image->store('products', 'public');

            $product->images()->create([
                'path'    => $path,
                'is_main' => $index === 0
            ]);
        }

        return redirect()->route('product.index', $user)->with('success', 'Produto cadastrado com sucesso!');
    }

    public function edit(Product $product) {
        $user = auth()->user();
        $companies = Company::where('id', $user->company_id)->get();
        $categories = Category::where('company_id', $user->company_id)->get();
        $brands = Brand::where('company_id', $user->company_id)->get();

        return view ('products.edit', compact('user', 'companies', 'categories', 'brands', 'product'));
    }

    public function update(Request $request, Product $product) {
        $user = auth()->user();

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products')
                    ->where(fn ($query) => $query->where('company_id', $request->company_id))
                    ->ignore($product->id) 
            ],
            'description' => 'required|string',
            'price'       => 'required|numeric|min:0',
            'company_id'  => 'required|exists:companies,id',
            'images.*'    => 'image|mimes:jpg,jpeg,png|max:5120'
        ], [
            'name.required'        => 'O nome do produto é obrigatório.',
            'name.max'             => 'O nome do produto não pode ter mais que 255 caracteres.',        
            'name.unique'          => 'Já existe um produto com este nome nesta empresa.',     
            'description.required' => 'A descrição é obrigatória.',
            'price.required'       => 'O preço é obrigatório.',
            'price.numeric'        => 'O preço deve ser um número.',
            'price.min'            => 'O preço não pode ser negativo.',
            'company_id.required'  => 'A empresa é obrigatória.',
            'company_id.exists'    => 'A empresa selecionada não existe.',
            'images.required'      => 'É necessário enviar pelo menos uma imagem.',
            'images.array'         => 'As imagens devem estar em formato de lista.',
            'images.max'           => 'Você pode enviar no máximo 10 imagens.',            
            'images.*.image'       => 'Cada arquivo deve ser uma imagem.',
            'images.*.mimes'       => 'As imagens devem estar nos formatos: jpg, jpeg ou png.',
            'images.*.max'         => 'Cada imagem deve ter no máximo 5MB.'
        ]);

        if ($request->filled('new_category')) {
            $category = Category::firstOrCreate(
                [
                    'name' => $request->new_category,
                    'company_id' => $request->company_id,
                ]
            );
            $categoryId = $category->id;
        } else {
            $categoryId = $request->category_id;
        }

        if (!$categoryId) {
            return back()->withErrors(['category_id' => 'Selecione ou crie uma categoria.']);
        }

        if ($request->filled('new_brand')) {
            $brand = Brand::firstOrCreate(
                [
                    'name' => $request->new_brand,
                    'company_id' => $request->company_id,
                ]
            );
            $brandId = $brand->id;
        } else {
            $brandId = $request->brand_id;
        }    

        if (!$brandId) {
            return back()->withErrors(['brand_id' => 'Selecione ou crie uma marca.']);
        }

        $product->update([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'company_id'  => $request->company_id,
            'category_id' => $categoryId,
            'brand_id'    => $brandId,
        ]);

        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imageId) {
                $image = $product->images()->find($imageId);
                if ($image) {
                    Storage::delete('public/'.$image->path);
                    $image->delete();
                }
            }
        }

        $mainImage = $product->images()->where('is_main', true)->first();

        if (!$mainImage) {
            $first = $product->images()->first();
            if ($first) {
                $first->update(['is_main' => true]);
            }
        }

        if ($request->hasFile('images')) {
            $existingCount = $product->images()->count();
            $files = $request->file('images');
            if (($existingCount + count($files)) > 10) {
                return back()->withErrors(['images' => 'O produto não pode ter mais que 10 imagens no total.']);
            }
    
            foreach ($files as $index => $image) {
                $path = $image->store('products', 'public');
    
                $product->images()->create([
                    'path'    => $path,
                    'is_main' => $existingCount === 0 && $index === 0
                ]);
            }
        }

        return redirect()->route('product.index', $user)->with('success', 'Produto editado com sucesso!');
    }

    public function destroy(Product $product) {
        $user = auth()->user();

        foreach ($product->images as $image) {
            Storage::delete('public/' . $image->path);
            $image->delete();
        }

        $product->delete();

        return redirect()->route('product.index', $user)->with('success', 'Produto excluído com sucesso!');
    }

    public function publicCatalog(Company $company) {
        $products = $company->products()->with(['brand', 'category', 'images'])->get();

        return view ('products.catalog', compact('company', 'products'));
    }
}
