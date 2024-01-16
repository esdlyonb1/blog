<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Core\Http\Response;

class ArticleController extends \Core\Controller\Controller
{



    public function index():Response
    {


        $articleRepository = new ArticleRepository();

        return $this->render("article/index", [
            "pageTitle"=>"Les articles",
            "articles"=>$articleRepository->findAll()
        ]);
    }


    public function show():Response
    {
            $id = null;

            if(!empty($_GET['id']) && ctype_digit($_GET['id'])){
                $id = $_GET['id'];
            }

            if(!$id){ return  $this->redirect();}

            $articleRepository = new ArticleRepository();
            $article = $articleRepository->find($id);

            if(!$article){
                return  $this->redirect();
            }


        return $this->render("article/show",[
            "pageTitle"=>$article->getTitle(),
            "article"=> $article
        ]);
    }

    public function create():Response
    {
        $title = null;
        $content = null;

        if(!empty($_POST['title'])){
            $title = $_POST['title'];
        }

        if(!empty($_POST['content'])){
            $content = $_POST['content'];
        }


        if($title && $content)
        {
            // seulement dans ce cas, une sauvegarde

            $article = new Article();

            $article->setTitle($title);
            $article->setContent($content);

            $articleRepository = new ArticleRepository();

           $article =  $articleRepository->save($article);

            return $this->redirect("?type=article&action=show&id=".$article->getId());


        }


        return $this->render("article/create", [
            "pageTitle"=>"Nouvel Article"
        ]);
    }

    public function update():Response
    {

        $idArticle = null;
        $title = null;
        $content = null;

        if(!empty($_POST['idArticle']) && ctype_digit($_POST['idArticle'])){
            $idArticle = $_POST['idArticle'];
        }

        if(!empty($_POST['title'])){
            $title = $_POST['title'];
        }

        if(!empty($_POST['content'])){
            $content = $_POST['content'];
        }


        if($title && $content && $idArticle)
        {
            $articleRepository = new ArticleRepository();
            $article = $articleRepository->find($idArticle);

            if(!$article){return $this->redirect();}

            $article->setTitle($title);
            $article->setContent($content);

            $articleRepository->edit($article);

            return $this->redirect("?type=article&action=show&id=".$article->getId());



        }



        $id = null;

        if(!empty($_GET['id']) && ctype_digit($_GET['id'])){
            $id = $_GET['id'];
        }

        if(!$id){ return  $this->redirect();}

        $articleRepository = new ArticleRepository();
        $article = $articleRepository->find($id);

        if(!$article){
            return  $this->redirect();
        }


        return $this->render("article/update",[
            "pageTitle"=>$article->getTitle(),
            "article"=> $article
        ]);

    }

    public function delete():Response
    {
        $id = null;

        if(!empty($_GET['id']) && ctype_digit($_GET['id'])){
            $id = $_GET['id'];
        }

        if(!$id){ return  $this->redirect();}

        $articleRepository = new ArticleRepository();
        $article = $articleRepository->find($id);

        if(!$article){
            return  $this->redirect();
        }

        $articleRepository->delete($article);

        return  $this->redirect("?type=article&action=index");

    }


}