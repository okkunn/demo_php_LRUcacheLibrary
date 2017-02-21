<?php

class LruCache {

	private $head;

	private $tail;

	private $capacity;

	private $hashmap;

	public function __construct($capacity) {
		$this->capacity = $capacity;
		$this->hashmap = array();
		$this->head = new Node(null, null);
		$this->tail = new Node(null, null);

		$this->head->setNext($this->tail);
		$this->tail->setPrevious($this->head);
	}

	public function get($key) {

		if (!isset($this->hashmap[$key])) {
			return null;
		}

		$node = $this->hashmap[$key];
		if (count($this->hashmap) == 1) {
			return $node->getData();
		}

		// refresh the access
		$this->detach($node);
		$this->attach($this->head, $node);

		return $node->getData();
	}

	public function put($key, $data) {
		if ($this->capacity <= 0) {
			return false;
		}
		
		if (isset($this->hashmap[$key]) && !empty($this->hashmap[$key])) {
			$node = $this->hashmap[$key];
			// update data
			$this->detach($node);
			$this->attach($this->head, $node);
			$node->setData($data);
		} else {
			$node = new Node($key, $data);
			$this->hashmap[$key] = $node;
			$this->attach($this->head, $node);

			// check if cache is full
			if (count($this->hashmap) > $this->capacity) {
				$nodeToRemove = $this->tail->getPrevious();
				$this->detach($nodeToRemove);
				unset($this->hashmap[$nodeToRemove->getKey()]);
			}
		}
		return true;
	}

	public function remove($key) {
		if (!isset($this->hashmap[$key])) {
			return false;
		}
		$nodeToRemove = $this->hashmap[$key];
		$this->detach($nodeToRemove);
		unset($this->hashmap[$nodeToRemove->getKey()]);
		
		return true;
	 }

	private function attach($head, $node) {
		$node->setPrevious($head);
		$node->setNext($head->getNext());
		$node->getNext()->setPrevious($node);
		$node->getPrevious()->setNext($node);
	}

	private function detach($node) {
		$node->getPrevious()->setNext($node->getNext());
		$node->getNext()->setPrevious($node->getPrevious());
	}

}

class Node {

	private $key;

	private $data;

	private $next;

	private $previous;

	public function __construct($key, $data) {
		$this->key = $key;
		$this->data = $data;
	}

	public function setData($data) {
		$this->data = $data;
	}

	public function setNext($next) {
		$this->next = $next;
	}

	public function setPrevious($previous) {
		$this->previous = $previous;
	}

	public function getKey() {
		return $this->key;
	}

	public function getData() {
		return $this->data;
	}

	public function getNext() {
		return $this->next;
	}

	public function getPrevious() {
		return $this->previous;
	}

}
