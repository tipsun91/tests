<?php

namespace App\Controller;


use App\Component\Controller;
use App\Model\AdjacencyList;


class AdjacencyListController extends Controller
{
	// Test3
	public function showTreeAction()
	{
		$model = new AdjacencyList;
		return $this->fetch('test.html.php', [
			'title' => __METHOD__,
			'content' => $model->getTree(),
		]);
	}

	// Test4
	public function showParentsAction()
	{
		$model = new AdjacencyList;
		return $this->fetch('test.html.php', [
			'title' => __METHOD__,
			'content' => $model->getParents(),
		]);
	}

	// Test5
	public function showChildrenAction()
	{
		$model = new AdjacencyList;
		return $this->fetch('test.html.php', [
			'title' => __METHOD__,
			'content' => $model->getChildren(),
		]);
	}
}
