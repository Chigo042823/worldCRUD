<?php 

class WorldControl extends World {
    public function updateCountry($params) {
        $this->updateCount($params);
    }

    public function insertCountry($params) {
        $this->insertCount($params);
    }

    public function deleteCountry($params) {
        $this->deleteCount($params);
    }
}

?>