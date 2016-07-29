<?php

namespace App\Controller;


use App\Component\Controller;
use App\Entity\CommentEntity;
use App\Model\CommentModel;


class CommentController extends Controller
{
	public function listAction()
	{
		$model = new CommentModel();

		return $this->fetch('comment.view.html.php', [
			'title' => 'Комментарии',
			'content' => $model->getTree(),
			'action' => '/comment/add',
			'ide' => 0,
		]);
	}

	public function answerAction($idi)
	{
		$model = new CommentModel();
		$entity = $model->get($idi);

		if (! $entity) {
			header('Location: /comment/list');
			exit();
		}

		return $this->fetch('comment.add.html.php', [
			'title' => 'Ответ',
			'action' => '/comment/add',
			'ide' => $idi,
		]);
	}

	public function addAction()
	{
		$model = new CommentModel();
		$entity = $model->get($_POST['ide']);
		$text = (isset($_POST['text']) && $_POST['text']) ? $_POST['text'] : 'У автора нет слов, закончились.';

		if ($entity && 5 > $entity->getLevel()) {
			$child = new CommentEntity();
			$child->setIde($entity->getIdi());
			$child->setText($text);
			$child->setDate('now');
			$child->setLevel($entity->getLevel() + 1);

			$model->save($child);
		} else if (0 == $_POST['ide']) {
			$child = new CommentEntity();
			$child->setIde(0);
			$child->setText($text);
			$child->setDate('now');
			$child->setLevel(0);

			$model->save($child);
		}

		header('Location: /comment/list');
		exit();
	}

	public function editAction($idi)
	{
		$model = new CommentModel();
		$entity = $model->get($idi);

		if (! $entity) {
			header('Location: /comment/list');
			exit();
		}

		if (isset($_POST['text']) && $_POST['text']) {
			$entity->setText($_POST['text']);

			$model->save($entity);

			header('Location: /comment/list');
			exit();
		}

		return $this->fetch('comment.edit.html.php', [
			'title' => 'Редактирование',
			'action' => '/comment/' . ((int) $idi) . '/edit',
			'text' => $entity->getText(),
		]);
	}

	public function deleteAction($idi)
	{
		$model = new CommentModel();
		$entity = $model->get($idi);

		if (! $entity) {
			header('Location: /comment/list');
			exit();
		}

		if (isset($_POST['text']) && $_POST['text']) {
			$model->delete($entity);
		}

		header('Location: /comment/list');
		exit();
	}
}
