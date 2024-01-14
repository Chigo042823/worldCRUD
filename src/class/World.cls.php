<?php 

    include 'dbh.cls.php';
    
    class World extends dbh {

        protected function getAllCounts() {
            $sql = "SELECT Code, Name, Continent, SurfaceArea, Population, GovernmentForm
            FROM country ORDER BY Name ASC";
            $stmt = $this->conn()->prepare($sql);
            $stmt->execute();

            $counts = $stmt->fetchAll();

            return $counts;
        }

        protected function searchCount($name) {
            $sql = "SELECT Code, Name, Continent, SurfaceArea, Population, GovernmentForm
            FROM country WHERE Name LIKE ? ORDER BY Name ASC";
            $stmt = $this->conn()->prepare($sql);
            $stmt->execute(["%$name%"]);

            $counts = $stmt->fetchAll();

            return $counts;
        }

        protected function getCountryByID($code) {
            $sql = "SELECT Code, Name, Continent, SurfaceArea, Population, GovernmentForm FROM 
            country WHERE Code = ?";
            $stmt = $this->conn()->prepare($sql);
            $stmt->execute([$code]);

            $count = $stmt->fetch();

            return $count;
        }

        protected function updateCount($params) {
            $sql = "UPDATE country SET Name = ?, Continent = ?,
             SurfaceArea = ?, Population = ?, GovernmentForm = ?
                WHERE Code = ?";
            $stmt = $this->conn()->prepare($sql);
            $stat = $stmt->execute($params);
        }

        protected function insertCount($params) {
            $sql = "INSERT INTO country (Code, Name, Continent, SurfaceArea, Population, GovernmentForm)
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->conn()->prepare($sql);
            $stat = $stmt->execute($params);
        }

        protected function deleteCount($params) {
            $sql = "DELETE FROM country WHERE Code = ?";
            $stmt = $this->conn()->prepare($sql);
            $stat = $stmt->execute([$params]);
        }

    }

?>