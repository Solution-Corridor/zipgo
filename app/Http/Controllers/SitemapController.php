<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Sitemap\SitemapGenerator;

use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class SitemapController extends Controller
{
   //     public function generate()
   //     {

   //      $file_path = public_path('sitemap.xml');

   //         File::delete($file_path);

   //         $sitemap = Sitemap::create()
   //         ->add(Url::create('/'))
   //         ->add(Url::create('/about'))
   //         ->add(Url::create('/test'));

   //         $sitemap->writeToFile(public_path('sitemap.xml'));

   //         return response()->view('sitemap')->header('Content-Type', 'text/xml');    
   // }

   public function generate()
   {
      $services = DB::select("SELECT * FROM services ORDER BY ser_id DESC");

      $sub_services = DB::select("SELECT b.sub_service_url as sub_service, s.service_url as service, b.created_at FROM sub_services as b
         JOIN services as s ON s.ser_id = b.ser_id
         ORDER BY b.sub_ser_id DESC");

      $blogs = DB::select("SELECT * FROM blogs ORDER BY blog_id DESC");

      $products = DB::select("SELECT * FROM products ORDER BY id DESC");

      $courses = DB::select("SELECT * FROM courses ORDER BY id DESC");

      // echo '<pre>';
      // print_r($sub_services);
      // die();

      return response()->view('sitemap', [
         'services' => $services,
         'sub_services' => $sub_services,
         'blogs' => $blogs,
         'products' => $products,
         'courses' => $courses
      ])->header('Content-Type', 'text/xml');
   }

   public function sale_bazar_generate()
   {
      $categories = DB::select("SELECT * FROM mk_categories ORDER BY id DESC");

      $sub_categories = DB::select("
         SELECT sc.*, c.category_name, c.url AS category_url
         FROM mk_sub_categories AS sc
         LEFT JOIN mk_categories AS c
            ON c.id = sc.cat_id
         ORDER BY sc.sub_cat_id DESC
      ");

      $products = DB::select("SELECT * FROM mk_products ORDER BY product_id DESC");

      $blogs = DB::table('blogs')
         ->orderBy('blog_id', 'desc')
         ->get();



      return response()->view('market.website.sitemap_xml', [
         'categories' => $categories,
         'sub_categories' => $sub_categories,
         'products' => $products,
         'blogs' => $blogs
      ])->header('Content-Type', 'text/xml');
   }

   public function sitemap_html()
   {
      // Categories
      $categories = DB::table('mk_categories')
         ->orderBy('id', 'desc')
         ->get();

      // Sub Categories (category_url is required in blade)
      $sub_categories = DB::table('mk_sub_categories as sc')
         ->leftJoin('mk_categories as c', 'c.id', '=', 'sc.cat_id')
         ->select(
            'sc.*',
            'c.url as category_url'
         )
         ->orderBy('sc.sub_cat_id', 'desc')
         ->get();

      // Products
      $products = DB::table('mk_products')
         ->orderBy('product_id', 'desc')
         ->get();

      $blogs = DB::table('blogs')
         ->orderBy('blog_id', 'desc')
         ->get();

      return view('market.website.sitemap_html', compact(
         'categories',
         'sub_categories',
         'products',
         'blogs'
      ));
   }
}
