<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use Core\Http\Response;

class CommentController extends \Core\Controller\Controller
{


    public function create():Response
    {

        $articleId = null;
        $content = null;

        if(!empty($_POST['articleId']) && ctype_digit($_POST['articleId']))
        {
            $articleId = $_POST['articleId'];
        }
        if(!empty($_POST['content']))
        {
            $content = $_POST['content'];
        }

        if($articleId && $content){

            $articleRepo = new ArticleRepository();
            $article = $articleRepo->find($articleId);

            if(!$article){return $this->redirect();}

            $comment = new Comment();
            $comment->setContent($content);
            $comment->setArticleId($articleId);

            $commentRepository = new CommentRepository();
            $commentRepository->save($comment);

            return $this->redirect("?type=article&action=show&id=".$article->getId());

        }

        return $this->redirect("?type=article&action=index");
    }
}