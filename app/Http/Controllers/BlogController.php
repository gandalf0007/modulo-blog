<?php

namespace Soft\Http\Controllers;
use Illuminate\Http\Request;
use Soft\Http\Requests;
use Soft\Http\Requests\BlogStoreRequest;
use Soft\Http\Requests\BlogUpdateRequest;
use Soft\Http\Requests\BlogCategoriaRequest;
use Soft\Http\Requests\BlogStatusRequest;
use Illuminate\Support\Collection as Collection;



use Soft\Blog_post;
use Soft\Blog_categoria;
use Soft\Blog_tag;
use Soft\Blog_post_tag;
use Soft\Blog_setting;


use Notification;
use DataTables;
use Debugbar;
use Alert;
use Session;
use Redirect;
use Storage;
use DB;
use Image;
use Auth;
use Flash;
use Toastr;
use Carbon\Carbon;
use Exception;
use MP;
use Input;
use Hash;
use View;




class BlogController extends BaseController
{

    //con este constructor llamo a las variales que hay en la clase padre que es BaseController
 public function __construct(){
       parent::__construct();
    }






/*------------------------------BLOG WEB-------------------------------*/
    public function BlogPost()
    {
        $posts = Blog_post::all();
        $categoriasBlog = Blog_categoria::all();
        $tags = Blog_tag::all();
       
        return view("shop.blog",compact('posts','categoriasBlog','tags'));
    }

    public function BlogPostItem($slug)
    {
        $post = Blog_post::where('slug','=',$slug)->first();
        $categoriasBlog = Blog_categoria::all();
        $settings = Blog_setting::first();
        return view("shop.blog-item",compact('post','categoriasBlog','settings'));
    }


     public function BlogPostCategoria($slug)
    {
        $category = Blog_categoria::where('slug','=',$slug)->first();
        $posts = Blog_post::where('blog_categoria_id','=',$category->id)->get();
        $categoriasBlog = Blog_categoria::all();
        $tags = Blog_tag::all();
        return view("shop.blog",compact('posts','categoriasBlog','tags'));
    }

    public function BlogPostTags($slug)
    {
        $tag = Blog_tag::where('slug','=',$slug)->first();
        $PostTags = Blog_post_tag::where('blog_tag_id','=',$tag->id)->get();

        foreach ($PostTags as $PostTag) {
            $posts = Blog_post::where('id','=',$PostTag->blog_post_id)->get();
        }

        $categoriasBlog = Blog_categoria::all();
        $tags = Blog_tag::all();
        return view("shop.blog",compact('posts','categoriasBlog','tags'));
    }
/*------------------------------BLOG WEB-------------------------------*/












/*------------------------------BLOG POST-------------------------------*/
  
    public function index()
    {
      
        $posts = Blog_post::paginate(20);
        $categorias = Blog_categoria::pluck('nombre','id');
        $tags = Blog_post_tag::all();
        return view("admin.blog.index",compact('posts','categorias','tags'));
    }



    public function indexDatatable(Request $request)
    { 
      //en el with se manda la relacion que esta en el modelo , como quiero obtener las categorias , no tengo que hacer refemcia a la tabla en la DB , si no que tengo que hacer referencia a la funcion que esta en el modelo , en nuestro caso categorias para las categoiras de los post

         $list= Blog_post::with('categoria','user')->get();
      return datatables()->of($list)->toJson();
    }



    public function edit(Request $request,$id)
    {
      
        $post = Blog_post::find($id);
         $categorias = Blog_categoria::pluck('nombre','id');
        $tags = Blog_post_tag::all();
        return view("admin.blog.edit",compact('post','categorias','tags'));
    }


    public function store(BlogStoreRequest $request)
    {
        
    
        
        $post = new Blog_post;
        
        
        //carpeta
         $nombreNoticia = $request['titulo'];
        $directory = "noticias/".$nombreNoticia;
        
         //pregunto si la imagen no es vacia y guado en $filename , caso contrario guardo null
        if(!empty($request->hasFile('imagen'))){
           $imagen = $request->file('imagen');
            $filename=time() . '.' . $imagen->getClientOriginalExtension();
            //crea la carpeta
            Storage::makeDirectory($directory);
            //esto es para q funcione en local 
            //image::make($imagen->getRealPath())->save( public_path('storage/'.$directory.'/'. $filename));
            image::make($imagen->getRealPath())->save('storage/'.$directory.'/'. $filename);
            $ruta = 'storage/'.$directory.'/'. $filename;
        }elseif(empty($request->hasFile('imagen'))){
            //crea la carpeta
            Storage::makeDirectory($directory);
            $filename = "noticia.jpg";
            $ruta = "storage/noticias/noticia.jpg"; 
        }


    
        $post->user_id = Auth::user()->id;
        $post->blog_categoria_id = $request['blog_categoria_id'];
        $post->titulo = $request['titulo'];
        $post->slug = str_slug($request['titulo'], '-'); 
        $post->descripcioncorta = $request['descripcioncorta'];
        $post->descripcionlarga = $request['descripcionlarga'];
        $post->status = "visible";
        $post->portada = $ruta;
        $post->imagen = $filename;
        $post->save();






         //si no envio tag q no se ejecute
        if (!empty($request['tag'])) {
         //recorro los tags y los voy guardadno si no se encuentran almacenados
        foreach ($request['tag'] as $id => $nombre) {
           $PostTag = new Blog_post_tag;
           $tag = Blog_tag::where('nombre','=',$nombre)->first();

           //si el tag ya se encuentra almacenado que me lo asocie con el post
           if (!empty($tag)) {
              $PostTag->blog_post_id = $post->id;
              $PostTag->blog_tag_id = $tag->id;
              $PostTag->save();
           }

           //si no se lo encuentra que me guarde el tag
           if (empty($tag)) {
              $tag = new Blog_tag;
              $tag->nombre = $nombre;
              $tag->slug = str_slug($nombre, '-'); 
              $tag->save();

              //y me crea la relacion en la tabla pivot
              $PostTag = new Blog_post_tag;
              $PostTag->blog_post_id = $post->id;
              $PostTag->blog_tag_id = $tag->id;
              $PostTag->save();
           }
        }
      }


     
        //le manda un mensaje al usuario
       Alert::success('Mensaje existoso', 'Post Creado');
       return Redirect::back();
    }





    public function update(BlogUpdateRequest $request,$id)
    {
       

         $post=Blog_post::find($id);

         //compruebo que el titulo no este repetido
        $postTituloRepetido = blog_post::where('titulo','=',$request['titulo'])->first();
         if (!empty($postTituloRepetido)) {
           if ($post->id != $postTituloRepetido->id) {
              flash('el titulo ya se encuentra en uso por otro post.')->error();
              return Redirect::back();
           }
         }

        
         //si se modifica el titulo , se tiene que crear una nueva carpeta con el nombre del titulo
         $newDirectorio = "noticias/".$request['titulo'];

         //viejo direcctorio
        $oldDirectory = "noticias/".$post->titulo;


        //si se modifico el titulo y se cambio la imagen
        //si modifico mi titulo que me cree una nueva carpeta
        if ($newDirectorio != $oldDirectory and !empty($request->hasFile('imagen'))) {
            //que me cree la nueva carpeta
            Storage::makeDirectory($newDirectorio);
            //que me pase la imagen de la vieja carpeta a esta
            //Storage::move($oldDirectory."/".$post->imagen, $newDirectorio."/".$post->imagen);
            //elimino la vieja carpeta
            Storage::deleteDirectory($oldDirectory);

            //eliminamos la imagen anterior    
            if($post->portada != "storage/noticias/noticia.jpg"){
            $directoryDelete = $post->titulo."/".$post->imagen;
            \Storage::disk('noticias')->delete($directoryDelete);
            }

             //me guarde la nueva imagen
             $imagen = $request->file('imagen');
            $filename=time() . '.' . $imagen->getClientOriginalExtension();
        
            //esto es para q funcione en local 
            //image::make($imagen->getRealPath())->save( public_path('storage/'.$directory.'/'. $filename));
            image::make($imagen->getRealPath())->save('storage/'.$newDirectorio.'/'. $filename);

            $ruta = 'storage/'.$newDirectorio.'/'.$filename;
            
        }




        //si solo se modifica el titulo
        //si modifico mi titulo que me cree una nueva carpeta
        if ($newDirectorio != $oldDirectory and empty($request->hasFile('imagen'))) {
            //que me cree la nueva carpeta
            Storage::makeDirectory($newDirectorio);
            //que me pase la imagen de la vieja carpeta a esta
            if($post->portada == "storage/noticias/noticia.jpg"){
                //que no me pase nada ya que esta la de por defecto
                $ruta = "storage/noticias/noticia.jpg";
              }else{   
            Storage::move($oldDirectory."/".$post->imagen, $newDirectorio."/".$post->imagen);
            $ruta = 'storage/'.$newDirectorio.'/'.$post->imagen;
            }
            //elimino la vieja carpeta
            Storage::deleteDirectory($oldDirectory);
        }




         //si solo se modifica la imagen
         //pregunto si la imagen no es vacia y guado en $filename , caso contrario guardo null
        if(!empty($request->hasFile('imagen')) and $newDirectorio == $oldDirectory){
            //eliminamos la imagen anterior    
            if($post->portada != "storage/noticias/noticia.jpg"){
            $directoryDelete = $post->titulo."/".$post->imagen;
            \Storage::disk('noticias')->delete($directoryDelete);
            }
            //me guarde la nueva imagen
            $imagen = $request->file('imagen');
            $filename=time() . '.' . $imagen->getClientOriginalExtension();
            //esto es para q funcione en local 
            //image::make($imagen->getRealPath())->save( public_path('storage/'.$directory.'/'. $filename));
            image::make($imagen->getRealPath())->save('storage/'.$oldDirectory.'/'. $filename);
            $ruta = 'storage/'.$oldDirectory.'/'. $filename;
        }


        //si no son vacios que se guarden lo que tienen
         if (!empty($filename)) {
            $post->imagen = $filename;
        }

        if (!empty($ruta)) {
            $post->portada = $ruta;
        }




        

       /*---------------TAG------------------*/

  //elimanmos todas las relacion del pivot antes de comenzar para despues cargar las unicamente la que mandamos por el formulario
        foreach ($post->tags as $tag) {
            //cuento las cantidades de tags actuales del post
          $RelacionPostTag = Blog_post_tag::where('blog_post_id','=',$post->id)->where('blog_tag_id','=',$tag->id)->first();
          $RelacionPostTag->delete();
          }



         //si no envio tag q no se ejecute
        if (!empty($request['tag'])) {/*1 if*/
      //recorro los tags enviados y los voy guardadno si no se encuentran almacenados
       foreach ($request['tag'] as $id => $nombre) {/*2 foreach*/

         $tagCargado = Blog_tag::where('nombre','=',$nombre)->first();
         

           //si el tag ya se encuentra almacenado que me lo asocie con el post
           if (!empty($tagCargado)) {
            //dd("se");
            //pregunto si existe la relacion en la tabla pivot
           $RelacionPostTag = Blog_post_tag::where('blog_post_id','=',$post->id)->where('blog_tag_id','=',$tagCargado->id)->first();
          //si es vacio significa que no hya una relacion en la tabla pivot por lo tanto la creo
           if (empty($RelacionPostTag)) {

            $PostTag = new Blog_post_tag;
            $PostTag->blog_post_id = $post->id;
            $PostTag->blog_tag_id = $tagCargado->id;
            $PostTag->save();
           }
         } 



           //si no se lo encuentra que me guarde el tag y me haga la relacion
           if (empty($tagCargado)) {
              $newtag = new Blog_tag;
              $newtag->nombre = $nombre;
              $newtag->slug = str_slug($nombre, '-'); 
              $newtag->save();

              //y que me haga la relacion en la tabla pivot
              $PostTag = new Blog_post_tag;
              $PostTag->blog_post_id = $post->id;
              $PostTag->blog_tag_id = $newtag->id;
              $PostTag->save();
           }

       
      }/*1 foreach*/
    }/*1 if*/

      /*---------------TAG------------------*/

        
        
        
        $post->blog_categoria_id = $request['blog_categoria_id'];
        $post->titulo = $request['titulo'];
        $post->slug = str_slug($request['titulo'], '-'); 
        $post->descripcioncorta = $request['descripcioncorta'];
        $post->descripcionlarga = $request['descripcionlarga'];
        $post->status = "visible";
        $post->save();

        //le manda un mensaje al usuario
       Alert::success('Mensaje existoso', 'Post Modificado');
       return Redirect::back();
    }



    public function CambiarStatus(BlogStatusRequest $request,$id)
    { 

        $post =  Blog_post::find($id);
        $post->status = $request['status'];
        $post->save();
        Alert::success('Mensaje existoso', 'Status cambiado Correctamente');

      return Redirect::back();
    }





    public function destroy($id)
    {
        $post=Blog_post::find($id);

        //eliminamos la carpeta.
        Storage::deleteDirectory("noticias/".$post->titulo);

        //eliminamos las relaciones Post-Tags
        $PostTags = Blog_post_tag::where('blog_post_id','=',$post->id)->get();
        foreach ($PostTags as $PostTag) {
            $PostTag->delete();
        }

        //eliminamos el post
        $post->delete();
        
        //le manda un mensaje al usuario
        Alert::success('Mensaje existoso', 'Post Eliminado');
        return Redirect::back();
    }
/*------------------------------BLOG POST-------------------------------*/

















/*------------------------------BLOG CATEGORIAS-------------------------------*/
public function BlogCategoriaIndex()
    {
        $categorias = Blog_categoria::all();
        return view("admin.blog.categorias.index",compact('categorias'));
    }

    public function BlogCategoriaStore(BlogCategoriaRequest $request)
    {
        $categoria = new Blog_categoria;
        $categoria->nombre = $request['nombre'];
        $categoria->slug = str_slug($request['nombre'], '-'); 
        $categoria->save();

        //le manda un mensaje al usuario
       Alert::success('Mensaje existoso', 'Categoria Creada');
       return Redirect::to('/blog-categorias');
    }


    public function BlogCategoriaUpdate(BlogCategoriaRequest $request,$id)
    {
         $categoria=Blog_categoria::find($id);
         $categoria->nombre =  $request['nombre'];
         $categoria->slug = str_slug($request['nombre'], '-'); 
         $categoria->save();
         Alert::success('Mensaje existoso', 'Categoria Modificada');
         return Redirect::to('/blog-categorias');

    }

    public function BlogCategoriaDestroy($id)
    {
        $categoria=Blog_categoria::find($id);

        $categoria->delete();
        
        //le manda un mensaje al usuario
        Alert::success('Mensaje existoso', 'Categoria Eliminada');
        return Redirect::back();
    }
/*------------------------------BLOG CATEGORIAS-------------------------------*/

















/*------------------------------BLOG TAGS-------------------------------*/
public function BlogTagsIndex()
    {
        $tags = Blog_tag::all();
        return view("admin.blog.tags.index",compact('tags'));
    }

    public function BlogTagsStore(BlogCategoriaRequest $request)
    {
        $tag = new Blog_tag;
        $tag->nombre = $request['nombre'];
        $tag->slug = str_slug($request['nombre'], '-'); 
        $tag->save();

        //le manda un mensaje al usuario
       Alert::success('Mensaje existoso', 'Tag Creado');
       return Redirect::to('/blog-Tags');
    }


    public function BlogTagsUpdate(BlogCategoriaRequest $request,$id)
    {
         $tag=Blog_tag::find($id);
         $tag->nombre =  $request['nombre'];
         $tag->slug = str_slug($request['nombre'], '-'); 
         $tag->save();
         Alert::success('Mensaje existoso', 'Tag Modificado');
         return Redirect::to('/blog-tags');
    }

    public function BlogTagsDestroy($id)
    {
        $tag=Blog_tag::find($id);

        //tambien elimino la relacion Post Tags
        $PostTags = Blog_post_tag::where('blog_tag_id','=',$tag->id)->get();
        foreach ($PostTags as $PostTag) {
            $PostTag->delete();
        }

        $tag->delete();
        
        //le manda un mensaje al usuario
        Alert::success('Mensaje existoso', 'Tag Eliminada');
        return Redirect::back();
    }
/*------------------------------BLOG TAGS-------------------------------*/


















/*------------------------------Settings-------------------------------*/
 public function BlogSettingsIndex()
    {
        $settings = Blog_setting::first();
       // dd($settings->disqus_html);
        $categorias = Blog_categoria::pluck('nombre','id');

        return view("admin.configuracion.blog.index",compact('settings','categorias'));
    }

     public function BlogSettingsDisqusStore(Request $request)
    {
 
        $settings = new Blog_setting;
        $settings->disqus_html = $request['disqus_html'];

        if ($request['enable'] == "on") {
             $settings->disqus_enable = 1;
        }else{
            $settings->disqus_enable = 0;
        }

        $settings->save();
         Alert::success('Mensaje existoso', 'Link Guardado');
        return Redirect::to('/blog-settings');
   
    }


    public function BlogSettingsDisqusUpdate(Request $request)
    {
         
        $settings =Blog_setting::first();
        $settings->disqus_html = $request['disqus_html'];

         if ($request['enable'] == "on") {
             $settings->disqus_enable = 1;
        }else{
            $settings->disqus_enable = 0;
        }

        $settings->save();
        Alert::success('Mensaje existoso', 'Link Guardado');
        return Redirect::to('/blog-settings');
   
    }



    public function BlogSettingsImagenStore(Request $request)
    {
        $settings =Blog_setting::first();

        if (empty($settings)) {
            $settings = new Blog_setting;
        }


        //carpeta
        $directory = "noticias/";
       
         //pregunto si la imagen no es vacia y guado en $filename , caso contrario guardo null
        if(!empty($request->hasFile('imagen'))){
           $imagen = $request->file('imagen');
            $filename=time() . '.' . $imagen->getClientOriginalExtension();

            //eliminio la imagen anterior
            //crea la carpeta
            //Storage::makeDirectory($directory);
            //esto es para q funcione en local 
            //image::make($imagen->getRealPath())->save( public_path('storage/'.$directory.'/'. $filename));
            image::make($imagen->getRealPath())->save('storage/'.$directory.'/'. $filename);
             $settings->image_defaul = "storage/noticias/".$filename;
              $settings->filename = $filename; 
            $settings->save();
        }


         Alert::success('Mensaje existoso', 'Imagen Guardado');
        return Redirect::to('/blog-settings');
   
    }


    public function BlogSettingsImagenUpdate(Request $request)
    {
        $settings =Blog_setting::first();

        //carpeta
        $directory = "noticias/";
       
         //pregunto si la imagen no es vacia y guado en $filename , caso contrario guardo null
        if(!empty($request->hasFile('imagen'))){
           $imagen = $request->file('imagen');
            $filename=time() . '.' . $imagen->getClientOriginalExtension();

            //eliminio la imagen anterior
            if ($settings->image_defaul != "storage/noticias/noticia.jpg" ) {
              \Storage::disk('noticias')->delete($settings->filename);
            }
            //crea la carpeta
            //Storage::makeDirectory($directory);
            //esto es para q funcione en local 
            //image::make($imagen->getRealPath())->save( public_path('storage/'.$directory.'/'. $filename));
            image::make($imagen->getRealPath())->save('storage/'.$directory.'/'. $filename);
             $settings->image_defaul = "storage/noticias/".$filename;
             $settings->filename = $filename; 
            $settings->save();
        }
         

         Alert::success('Mensaje existoso', 'Imagen Modificada');
        return Redirect::to('/blog-settings');
   
    }


/*------------------------------Settings-------------------------------*/
}
