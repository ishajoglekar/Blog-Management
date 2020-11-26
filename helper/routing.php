<?php
require_once 'init.php';

if(isset($_POST['page']))
 {

    if($di->get('auth')->check()){
        $check = $di->get('auth')->user();
    //    Util::dd($check);
        $id = $check[0]['id'];
    }
    //  Util::Dd($_POST);
    $dependency="";
    if($_POST['page'] == 'manage-all-posts')
    {
        $dependency = 'post';
    }
    elseif($_POST['page'] == 'manage-post')
    {
        // Util::Dd("hy");
        $dependency = 'post';
        $search_parameter = $_POST['search']['value'] ?? null;
        $order_by = $_POST['order'] ?? null;
        $start = $_POST['start'];
        $length = $_POST['length'];
        $draw = $_POST['draw'];
        
        
        $di->get($dependency)->getJSONDataForDataTableById($draw,$search_parameter,$order_by,$start,$length,$id);
        return true;
   
    }
    elseif($_POST['page'] == 'view-all-posts')
    {
        $dependency = 'post';
    }
    elseif($_POST['page'] == 'manage-all-users')
    {
        $dependency = 'user';
    } elseif($_POST['page'] == 'manage-categories')
    {
        $dependency = 'category';
    }
    elseif($_POST['page'] == "session-delete")
    {
       // Util::dd("hi");
        $di->get('auth')->signout();
        return true;
    }
    $search_parameter = $_POST['search']['value'] ?? null;
    $order_by = $_POST['order'] ?? null;
    $start = $_POST['start'];
    $length = $_POST['length'];
    $draw = $_POST['draw'];
    
    // Util::dd("hi");
    $di->get($dependency)->getJSONDataForDataTable($draw,$search_parameter,$order_by,$start,$length);
   
}

if(isset($_POST['add_user']))
{
    // Util::dd("hey");
    if(Util::verifyCSRFToken($_POST))
    {
        $result = $di->get('user')->addUser($_POST);
        
        
        switch($result)
        {
            case ADD_ERROR:
                Session::setSession(ADD_ERROR,"Add user Error");
                Util::redirect("dashboard/register.php");
                break;
            case ADD_SUCCESS:
                Session::setSession(ADD_SUCCESS,"Add user Success");
                Util::redirect("dashboard/login.php");
                break;
            case VALIDATION_ERROR:
                Session::setSession('validation',"Validation Error");
                Session::setSession('old',$_POST);
                Session::setSession('errors',serialize($di->get('user')->getValidator()->errors()));//object mai hai ya array hai to text mai store kar sakeee!
                Util::redirect("dashboard/register.php");
                break;
        }
        
      
    }
}

if(isset($_POST['add_category']))
{
    // Util::dd("hey");
    if(Util::verifyCSRFToken($_POST))
    {
        $result = $di->get('category')->addCategory($_POST);
        
        switch($result)
        {
            case ADD_ERROR:
                Session::setSession(ADD_ERROR,"Add user Error");
                Util::redirect("dashboard/add-category.php");
                break;
            case ADD_SUCCESS:
                Session::setSession(ADD_SUCCESS,"Add user Success");
                Util::redirect("dashboard/manage-categories.php");
                break;
            case VALIDATION_ERROR:
                Session::setSession('validation',"Validation Error");
                Session::setSession('old',$_POST);
                Session::setSession('errors',serialize($di->get('user')->getValidator()->errors()));//object mai hai ya array hai to text mai store kar sakeee!
                Util::redirect("dashboard/add-category.php");
                break;
        }
        
      
    }
}

if(isset($_POST['editUser']))
{
    // Util::dd($_POST);
    if(Util::verifyCSRFToken($_POST))
    {
        
        $result = $di->get('user')->update($_POST,$_POST['edit_post_id']);

        
        switch($result)
        {
            case UPDATE_ERROR:
                Session::setSession(UPDATE_ERROR,"Update User Error");
                Util::redirect("dashboard/edit-users.php?id=".$_POST['edit_post_id']);
                break;
            case UPDATE_SUCCESS:
                Session::setSession(UPDATE_SUCCESS,"Update User Success");
                Util::redirect("dashboard/manage-users.php");
                break;
            case VALIDATION_ERROR:
                Session::setSession('validation',"Validation Error");
                Session::setSession('old',$_POST);
                Session::setSession('errors',serialize($di->get('user')->getValidator()->errors()));//object mai hai ya array hai to text mai store kar sakeee!
                Util::redirect("dashboard/edit-user.php?id=".$_POST['edit_post_id']);
                break;
        }
    }else{
        //errorpage 
        Session::setSession("csrf","CSRF ERROR");
        Util::redirect("dashboard/manage-users.php");//Need to change this, actually we be redirecting to some error page indicating Unauthorized access.

    }
}

if(isset($_POST['editCategory']))
{
    // Util::dd($_POST);
    if(Util::verifyCSRFToken($_POST))
    {
        
        $result = $di->get('category')->update($_POST,$_POST['edit_category_id']);

        
        switch($result)
        {
            case UPDATE_ERROR:
                Session::setSession(UPDATE_ERROR,"Update Category Error");
                Util::redirect("dashboard/edit-category.php?id=".$_POST['edit_post_id']);
                break;
            case UPDATE_SUCCESS:
                Session::setSession(UPDATE_SUCCESS,"Update Category Success");
                Util::redirect("dashboard/manage-categories.php");
                break;
            case VALIDATION_ERROR:
                Session::setSession('validation',"Validation Error");
                Session::setSession('old',$_POST);
                Session::setSession('errors',serialize($di->get('user')->getValidator()->errors()));//object mai hai ya array hai to text mai store kar sakeee!
                Util::redirect("dashboard/edit-category.php?id=".$_POST['edit_post_id']);
                break;
        }
    }else{
        //errorpage 
        Session::setSession("csrf","CSRF ERROR");
        Util::redirect("dashboard/manage-users.php");//Need to change this, actually we be redirecting to some error page indicating Unauthorized access.

    }
}


if(isset($_POST['add_user_by_admin']))
{
    // Util::dd("hey");
    if(Util::verifyCSRFToken($_POST))
    {
        $result = $di->get('user')->addUserByAdmin($_POST);
        // Util::dd("hey");
        
        switch($result)
        {
            case ADD_ERROR:
                Session::setSession(ADD_ERROR,"Add user Error");
                Util::redirect("dashboard/add-user.php");
                break;
            case ADD_SUCCESS:
                Session::setSession(ADD_SUCCESS,"Add user Success");
                Util::redirect("dashboard/manage-users.php");
                break;
            case VALIDATION_ERROR:
                Session::setSession('validation',"Validation Error");
                Session::setSession('old',$_POST);
                Session::setSession('errors',serialize($di->get('user')->getValidator()->errors()));//object mai hai ya array hai to text mai store kar sakeee!
                Util::redirect("dashboard/add-user.php");
                break;
        }
        
      
    }
}

if(isset($_POST['add_post']))
{
    // Util::dd($_FILES);
    if(Util::verifyCSRFToken($_POST))
    {
        $result = $di->get('post')->addPost($_POST);
        
        // Util::dd($result);
        switch($result)
        {
            case ADD_ERROR:
                
                Session::setSession(ADD_ERROR,"Add user Error");
                Util::redirect("dashboard/add-post.php");
                break;
            case ADD_SUCCESS:
                
                Session::setSession(ADD_SUCCESS,"Add user Success");
                // Util::Dd("hey isha here");
                $idFetch = $di->get('post')->getIDByPostName($_POST['name'],PDO::FETCH_ASSOC);
                // Util::dd($idFetch);
                $id = (int)$idFetch[0]['id'];
                Util::redirect("posts/blog-post.php?id=".$id);
                break;
            case VALIDATION_ERROR:
                Session::setSession('validation',"Validation Error");
                Session::setSession('old',$_POST);
                Session::setSession('errors',serialize($di->get('user')->getValidator()->errors()));//object mai hai ya array hai to text mai store kar sakeee!
                Util::redirect("dashboard/add-post.php");
                break;
        }
        
      
    }
}

if(isset($_POST['signin']))
{
    
    // Util::redirect("../helper_classes/MailConfigHelper.php");
    if(Util::verifyCSRFToken($_POST))
    {
        $result = $di->get('user')->signIn($_POST);
        
        
        switch($result)
        {
            case SIGNIN_ERROR:
                Session::setSession(SIGNIN_ERROR,"Add user Error");
                Util::redirect("dashboard/login.php");
                break;
            case SIGNIN_SUCCESS:
                Session::setSession(SIGNIN_SUCCESS,"Add user Success");
                User::$login = true;
                //Util::redirect("posts/blog-home.php?authority=".$checkAuthority);
                Util::redirect("posts/blog-home.php");
                break;
            case VALIDATION_ERROR:
                Session::setSession('validation',"Validation Error");
                Session::setSession('old',$_POST);
                Session::setSession('errors',serialize($di->get('user')->getValidator()->errors()));//object mai hai ya array hai to text mai store kar sakeee!
                Util::redirect("dashboard/login.php");
                break;
        }
       
    }
}

if(isset($_POST['loggedout']))
{
    $di->get('auth')->signout();
    Util::redirect("dashboard/login.php");
}

if(isset($_POST['guest']))
{
    if(Util::verifyCSRFToken($_POST))
    {
        Util::redirect("posts/blog-home.php");
    }
}
if(isset($_POST['resetRequest']))
{
    if(Util::verifyCSRFToken($_POST))
    {
        // Util::dd("isha");
        $di->get('user')->requestPasswordReset($_POST,$di->get('mail'));
        Util::redirect("dashboard/forgot-password.php");
    }
}



    

if(isset($_GET['resetPassword']))
{
    if(Util::verifyCSRFToken($_GET))
    {
        // Util::dd($_GET);
        $di->get('user')->resetPassword($_GET);
    }
}


if(isset($_POST['edit_post_data'])){
    
    // Util::dd($_POST);
     
    Util::redirect('/dashboard/edit-post.php?id='.$_POST['post_id']);
    
 }
 else if(isset($_POST['edit_user_data'])){
    
    // Util::dd($_POST);
     
    Util::redirect('/dashboard/edit-user.php?id='.$_POST['user_id']);
    
 }else if(isset($_POST['edit_category_data'])){
    
    // Util::dd($_POST['category_id']);
     
    Util::redirect('/dashboard/edit-category.php?id='.$_POST['category_id']);
    
 }

if(isset($_POST['editPost']))
{
    // Util::dd($_POST);
    if(Util::verifyCSRFToken($_POST))
    {
       
        $result = $di->get('post')->update($_POST,$_POST['post_id']);
        // Util::dd($result);
        switch($result)
        {
            
            case UPDATE_ERROR:
                Session::setSession(UPDATE_ERROR,"Update Post Error");
                Util::redirect("dashboard/edit-post.php");
                break;
            case UPDATE_SUCCESS:
                Session::setSession(UPDATE_SUCCESS,"Update post Success");
                $idFetch = $di->get('post')->getIDByPostName($_POST['name'],PDO::FETCH_ASSOC);
                $id = (int)$idFetch[0]['id'];
                Util::redirect("posts/blog-post.php?id=".$id);
                break;
            case VALIDATION_ERROR:
                Session::setSession('validation',"Validation Error");
                Session::setSession('old', $_POST);
                Session::setSession('errors',serialize($di->get('post')->getValidator()->errors()));//object mai hai ya array hai to text mai store kar sakeee!
                Util::redirect("dashboard/edit-post.php?id=".$_POST['post_id']);
                break;
        }
    }else{
        //errorpage 
        Session::setSession("csrf","CSRF ERROR");
        Util::redirect("manage-post.php");//Need to change this, actually we be redirecting to some error page indicating Unauthorized access.

    }
}
    

if(isset($_POST['deletePost']))
{
    // Util::dd($_POST);
    if(Util::verifyCSRFToken($_POST))
    {
        
        $result = $di->get('post')->delete($_POST['id']);

        // Util::dd($result);
        switch($result)
        {
            
            case DELETE_ERROR:
                Session::setSession(DELETE_ERROR,"Update post Error");
                Util::redirect("dashboard/manage-all-posts.php");
                break;
            case DELETE_SUCCESS:
                Session::setSession(DELETE_SUCCESS,"Update post Success");
                Util::redirect("dashboard/manage-all-posts.php");
                break;
        }
    }else{
        //errorpage 
        Session::setSession("csrf","CSRF ERROR");
        Util::redirect("manage-post.php");//Need to change this, actually we be redirecting to some error page indicating Unauthorized access.

    }
}

if(isset($_POST['deleteUser']))
{
    // Util::dd($_POST);
    if(Util::verifyCSRFToken($_POST))
    {
        
        $result = $di->get('user')->delete($_POST['id']);

        // Util::dd($result);
        switch($result)
        {
            
            case DELETE_ERROR:
                Session::setSession(DELETE_ERROR,"Update post Error");
                Util::redirect("dashboard/manage-users.php");
                break;
            case DELETE_SUCCESS:
                Session::setSession(DELETE_SUCCESS,"Update post Success");
                Util::redirect("dashboard/manage-users.php");
                break;
        }
    }else{
        //errorpage 
        Session::setSession("csrf","CSRF ERROR");
        Util::redirect("manage-post.php");//Need to change this, actually we be redirecting to some error page indicating Unauthorized access.

    }
}


if(isset($_POST['deleteMyPost']))
{
    // Util::dd($_POST);
    if(Util::verifyCSRFToken($_POST))
    {
        
        $result = $di->get('post')->delete($_POST['id']);

        // Util::dd($result);
        switch($result)
        {
            
            case DELETE_ERROR:
                Session::setSession(DELETE_ERROR,"Update post Error");
                Util::redirect("dashboard/manage-post.php");
                break;
            case DELETE_SUCCESS:
                Session::setSession(DELETE_SUCCESS,"Update post Success");
                Util::redirect("dashboard/manage-post.php");
                break;
        }
    }else{
        //errorpage 
        Session::setSession("csrf","CSRF ERROR");
        Util::redirect("manage-post.php");//Need to change this, actually we be redirecting to some error page indicating Unauthorized access.

    }
}

if(isset($_POST['deleteCategory']))
{
    // Util::dd($_POST);
    if(Util::verifyCSRFToken($_POST))
    {
        // Util::dd($_POST);
        
        $result = $di->get('category')->delete($_POST['id']);

        // Util::dd($result);
        switch($result)
        {
            
            case DELETE_ERROR:
                Session::setSession(DELETE_ERROR,"Update post Error");
                Util::redirect("dashboard/manage-categories.php");
                break;
            case DELETE_SUCCESS:
                Session::setSession(DELETE_SUCCESS,"Update post Success");
                Util::redirect("dashboard/manage-categories.php");
                break;
        }
    }else{
        //errorpage 
        Session::setSession("csrf","CSRF ERROR");
        Util::redirect("manage-categories.php");//Need to change this, actually we be redirecting to some error page indicating Unauthorized access.

    }
}



if(isset($_POST['favs']))
{
    
    if(Session::getSession('csrf_token') == $_POST['csrf_token'])
    {
        
        $favArr = array();
        foreach(array_keys($_POST) as $i){
            // Util::dd(($i!= 'csrf_token'));
            if($i!='favs' && $i!='csrf_token')
               array_push($favArr,(int)$di->get('category')->getCategoryIDByName($i)[0]['id']);
        }

        // Util::Dd($favArr);
        
        $result = $di->get('post')->syncFavs($favArr,$di->get('auth')->user());

        // Util::dd($result);
        switch($result)
        {
            
            case DELETE_ERROR:
                Session::setSession(DELETE_ERROR,"Update post Error");
                Util::redirect("posts/liked-posts.php");
                break;
            case DELETE_SUCCESS:
                Session::setSession(DELETE_SUCCESS,"Update post Success");
                Util::redirect("posts/liked-posts.php");
                break;
        }
    }else{
        //errorpage 
        Session::setSession("csrf","CSRF ERROR");
        Util::redirect("posts/liked-posts.php");//Need to change this, actually we be redirecting to some error page indicating Unauthorized access.

    }
}


?>
