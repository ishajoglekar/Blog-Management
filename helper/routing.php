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




?>