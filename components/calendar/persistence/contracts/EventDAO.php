<?php

namespace app\components\calendar\persistence\contracts;

interface EventDAO {
    public function findById(int $id);
    public function findNext();
    public function save(array $data);
    public function update(array $data);
    public function delete(int $id);
}