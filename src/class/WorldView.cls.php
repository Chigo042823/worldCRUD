<?php 

    class WorldView extends World {

        public function getAllCountries() {
            return $this->getAllCounts();
        }

        public function getCountryByCode($countryCode) {
            return $this->getCountryByID($countryCode);
        }
        
        public function searchCountry($countryName) {
            return $this->searchCount($countryName);
        }

    }

?>