<?php

namespace App\Classes\Core;
use App\Classes\Core\Dbase;

class AbstractRepository extends Dbase
{
    protected $table;
    private $db;

    /** 
     * cherche toutes les lignes
     * sql : select * from <<name_table>>
     * @return array.
     */

    public function findAll() {
        $sql= 'SELECT * FROM '. $this->table; 
        $result = $this->requete($sql);
        return $result->fetchAll();
    }
    
    /** 
     * cherche touts les lignes par critère
     * select * from <<name_table>> where columns_name = ? and columns_name2 = ? 
     * @param array.
     * @return array.
     */

    public function findBy(array $criteria) {
        $columns = [];
        $values = [];
        foreach($criteria as $columnName => $value) {
            $columns[] = "$columnName = ?";
            $values [] = $value;
        }
        $list_of_columns = implode(' AND ', $columns);
        $sql = 'SELECT * FROM '.$this->table. ' WHERE '. $list_of_columns;

        $result = $this->requete($sql, $values) ;
        return  $result->fetchAll();
    }
    
    /**
     * cette méthode permet de chercher une ligne par son id.
     * @param int $id 
     * @return array
     */
    
    public function find(int $id ){
      return  $this->findBy(['id'=>$id]);
    }

    /**
     * Cette méthode éxecute une requette : create .
     * @param $model un objet qui représente classe métier.
     * 
     */

    public function create(ModelIterator $model) {
        $columns = [];
        $values = [];
        $bind = [];

        foreach ($model->getAttributes() as $field => $value) {
                $columns[] = $field;
                $bind[] = "?";
                $values[] = $value;
        }
        $list_of_columns = implode(', ',$columns);
        $list_of_bind = implode(', ', $bind);

        $sql = 'INSERT INTO '.$this->table. '('.$list_of_columns. ') VALUES('.$list_of_bind.')';
        return $this->requete($sql, $values);
    }

    /** 
     * cette fonction execute une requete: UPDATE <<TABLE>> SET <<column1>>= ?,   *<<column2>> = ?, <<column3>> = ? WHERE id= ?
     * @param $id identifient de la ligne dans la bd.
     * @param $model repesente un objet une classe métier.
     */

    public function update(int $id, ModelIterator $model)
    {
        $columns = [];
        $values = [];
        foreach($model->getAttributes() as $field => $value){
            if(!is_null($value)){
                $columns[] = "$field = ?";
                $values[] = $value;
            }
        }
        $values[] = $id;

        // On transforme le tableau "champs" en une chaine de caractères
        $list_of_columns = implode(', ', $columns);

        $sql = 'UPDATE '.$this->table.' SET '. $list_of_columns.' WHERE id = ?';
        // On exécute la requête
        return $this->requete($sql, $values);
    }

    /** 
     * Cette fonction Exexute une requete sql DELETE FROME <<TABLE>> WHERE id =  ?
     * @param array $attributs clé => valeur.
     * 
     */

    public function delete(array $attributs)
    {
        $columns = [];
        $values = [];
        foreach($attributs as $columnName => $value) {
            $columns[] = "$columnName = ?";
            $values [] = $value;
        }
        $list_of_columns = implode(' AND ', $columns);

        $sql = 'DELETE FROM '.$this->table. ' WHERE '. $list_of_columns;
        return $this->requete($sql, $values);
    }

    /** 
     * cette méthode execute une rquette sql.
     * @param $sql code sql
     * @param array $attributs valeurs des colonnes d'une table
     */

    private function requete(string $sql, array $attributs = null)
    {
        $this->db = Dbase::getInstance();

        // On vérifie s'il y a des attributs
        if(!is_null($attributs)){
            //requette sql preparée
            $query = $this->db->prepare($sql);
            $query->execute($attributs);
            if (preg_match("/^INSERT\s/i", $sql, $matches)) {

                return $this->db->lastInsertId();
            } else {
                return $query;
            }
            
        }else{

            return $this->db->query($sql);
        }
    }


}