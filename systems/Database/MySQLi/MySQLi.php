<?php

    namespace Philum\Database\MySQLi;

    use \Philum\Database\Database;
    use Exception;

    class MySQLi {

        /**
         * @var Database $DBConnection
         */
        protected Database $DBConnection;

        /**
         * @var $cacheQuery
         */
        private $cacheQuery = false;

        /**
         * @var $cacheSelect
         */
        private $cacheSelect = false;

        /**
         * @var $cacheFrom
         */
        private $cacheFrom = false;
        
        /**
         * @var $cacheWhere
         */
        private $cacheWhere = false;

        /**
         * @var $cacheOrderBy
         */
        private $cacheOrderBy = false;

        /**
         * @var $cacheLimit
         */
        private $cacheLimit = false;

        /**
         * @var $cacheJoin
         */
        private $cacheJoin = false;

        public function __construct() {
            $this->DBConnection = new Database();
        }

        /**
         * ===========================
         * Statement
         * ===========================
         */
        /**
         * Sets the SELECT part of the SQL query.
         *
         * @param  string $columns - Columns to be selected.
         */
        public function select(string $columns) {
            $select = "SELECT ". $this->sanitizeIdentifier($columns);
            $this->cacheSelect = $select;

            return $this;
        }

        /**
         * Sets the FROM part of the SQL query.
         *
         * @param  string $table - Table name.
         */
        public function from(string $table) {
            if($this->cacheSelect) {
                $from = $this->cacheSelect ." FROM ". $this->sanitizeIdentifier($table);
                $this->cacheFrom = $from;
            } else {
                throw new Exception("Select statement is not initialized.");
            }

            return $this;
        }

        /**
         * Sets the WHERE part of the SQL query.
         *
         * @param   $condition - Condition for the WHERE clause.
         */
        public function where( $condition) {
            $this->cacheWhere = " WHERE " . $this->buildCondition($condition);

            return $this;
        }

        /**
         * Sets the WHERE IN part of the SQL query.
         *
         * @param   $column - Column name.
         * @param  array $values - Array of values.
         */
        public function whereIn( $column, array $values) {
            $escapedValues = array_map([$this->DBConnection->connection(), "real_escape_string"], $values);
            $this->cacheWhere = " WHERE " . $this->sanitizeIdentifier($column) . " IN ('" . implode("', '", $escapedValues) . "')";

            return $this;
        }

        /**
         * Sets the WHERE NOT part of the SQL query.
         *
         * @param   $condition - Condition for the WHERE NOT clause.
         */
        public function whereNot($condition) {
            $this->cacheWhere = " WHERE NOT " . $this->buildCondition($condition);

            return $this;
        }

        /**
         * Sets the ORDER BY part of the SQL query.
         *
         * @param   $order - Order condition.
         */
        public function orderBy($order) {
            if(is_array($order)) {
                $order = implode(', ', array_map([$this, 'sanitizeIdentifier'], $order));
            } else {
                $order = $this->sanitizeIdentifier($order);
            }
            $this->cacheOrderBy = " ORDER BY " . $order;

            return $this;
        }

        /**
         * Sets the LIMIT part of the SQL query.
         *
         * @param   $limit - Limit value.
         */
        public function limit($limit) {
            if(is_array($limit)) {
                $limit = implode(', ', array_map('intval', $limit));
            } else {
                $limit = intval($limit);
            }
            $this->cacheLimit = " LIMIT " . $limit;

            return $this;
        }

        /**
         * Sets the JOIN part of the SQL query.
         *
         * @param  string $table - Table name.
         * @param  string $on - Join condition.
         * @param  string $type - Type of join (default: "INNER").
         */
        public function join(string $table, string $on, string $type = "INNER") {
            $this->cacheJoin .= " $type JOIN " . $this->sanitizeIdentifier($table) . " ON " . $this->sanitizeIdentifier($on);
            
            return $this;
        }

        /**
         * Executes a raw SQL query.
         *
         * @param  string $sql - SQL query.
         * @return $this
         * @throws \Exception
         */
        public function query($sql) {
            $query = $this->DBConnection->connection()->query($sql);
    
            if(!$query) {
                throw new \Exception("Query failed: " . $this->DBConnection->connection()->error);
            }
    
            $this->cacheQuery = $query;

            return $this;
        }

        /**
         * Executes a raw SQL query and returns $this.
         *
         * @param  string $sql - SQL query.
         */
        public function rawQuery(string $sql) {
            $this->query($sql);

            return $this;
        }

        /**
         * Executes the built SELECT query.
         *
         * @param  string|false $table - Optional table name.
         */
        public function get($table = false) {
            $sql = $this->buildFinalQuery($table);
            $this->query($sql);

            return $this;
        }

        /**
         * Executes the built SELECT query with a WHERE condition.
         *
         * @param  string|false $table - Optional table name.
         * @param   $where - WHERE condition.
         * @return $this
         * @throws \Exception
         */
        public function getWhere($table = false, $where = false) {
            if(!$where) {
                throw new \Exception("No 'where' condition provided.");
            }
            $this->where($where);
            $sql = $this->buildFinalQuery($table);
            $this->query($sql);

            return $this;
        }

        /**
         * Executes an INSERT query.
         *
         * @param  string $table - Table name.
         * @param  array $data - Data to insert.
         */
        public function insert(string $table, array $data) {
            $columns = implode(", ", array_map([$this, 'sanitizeIdentifier'], array_keys($data)));
            $values = implode("', '", array_map([$this->DBConnection->connection(), 'real_escape_string'], array_values($data)));
            $sql = "INSERT INTO " . $this->sanitizeIdentifier($table) . " ($columns) VALUES ('$values')";
            $this->query($sql);

            return $this;
        }

        /**
         * Executes an INSERT query for multiple rows.
         *
         * @param  string $table - Table name.
         * @param  array $data - Data to insert (array of rows).
         */
        public function insertMultiple(string $table, array $data) {
            $columns = implode(", ", array_map([$this, 'sanitizeIdentifier'], array_keys($data[0])));
            $values = [];

            foreach($data as $row) {
                $escapedValues = implode("', '", array_map([$this->DBConnection->connection(), 'real_escape_string'], array_values($row)));
                $values[] = "('$escapedValues')";
            }

            $sql = "INSERT INTO " . $this->sanitizeIdentifier($table) . " ($columns) VALUES " . implode(", ", $values);
            $this->query($sql);

            return $this;
        }

        /**
         * Executes an UPDATE query.
         *
         * @param  string $table - Table name.
         * @param  array $data - Data to update.
         * @param   $where - WHERE condition.
         */
        public function update(string $table, array $data, $where) {
            $set = [];
            foreach($data as $column => $value) {
                $escapedValue = $this->DBConnection->connection()->real_escape_string($value);
                $set[] = $this->sanitizeIdentifier($column) . " = '$escapedValue'";
            }

            $sql = "UPDATE " . $this->sanitizeIdentifier($table) . " SET " . implode(", ", $set) . $this->buildCondition($where, true);
            $this->query($sql);

            return $this;
        }

        /**
         * Executes a DELETE query.
         *
         * @param  string $table - Table name.
         * @param   $where - WHERE condition.
         */
        public function delete(string $table, $where) {
            $sql = "DELETE FROM " . $this->sanitizeIdentifier($table) . $this->buildCondition($where, true);
            $this->query($sql);

            return $this;
        }

        /**
         * Begins a transaction.
         */
        public function begin() {
            $this->DBConnection->connection()->begin_transaction();
        }

        /**
         * Commits the current transaction.
         */
        public function commit() {
            $this->DBConnection->connection()->commit();
        }

        /**
         * Rolls back the current transaction.
         */
        public function rollback() {
            $this->DBConnection->connection()->rollback();
        }

        /**
         * ===========================
         * Result
         * ===========================
         */
         /**
         * Returns all results from the last executed query.
         *
         * @return array|object - Array or object of results.
         * @throws \Exception
         */
        public function result() {
            return $this->fetchAll(true);
        }

        /**
         * Fetches all results as an associative array or object.
         *
         * @param  bool $toObject - Return as object if true.
         * @return array|object
         * @throws \Exception
         */
        public function fetchAll(bool $toObject = false) {
            if (!$this->cacheQuery) {
                throw new \Exception("No cached query result found.");
            }

            $fetchAll = $this->cacheQuery->fetch_all(MYSQLI_ASSOC);

            if ($toObject) {
                $fetchAll = (object) $fetchAll;
            }

            $this->clearCache();

            return $fetchAll;
        }

        /**
         * Fetches a single row from the result set.
         *
         * @param  string $getFrom - Fetch "last" or "first" row (default: "last").
         * @return array|object
         * @throws \Exception
         */
        public function fetchRow(string $getFrom = "last") {
            if(!$this->cacheQuery) {
                throw new \Exception("No cached query result found.");
            }

            $fetchRow = $this->fetchAll(true);

            if($getFrom === "last") {
                $fetchRow = end($fetchRow);
            } else {
                $fetchRow = reset($fetchRow);
            }

            return $fetchRow;
        }

        /**
         * Fetches a result row as an associative array.
         *
         * @return array
         */
        public function fetchAssoc() {
            return $this->cacheQuery->fetch_assoc();
        }

        /**
         * Fetches a result row as an enumerated array.
         *
         * @return array
         */
        public function fetchArray() {
            return $this->cacheQuery->fetch_array();
        }

        /**
         * Fetches a result row as an object.
         *
         * @return object
         */
        public function fetchObject() {
            return $this->cacheQuery->fetch_object();
        }

        /**
         *  Returns the number of rows in the result set. 
         * 
         * @return int
         */
        public function numRows() {
            if (!$this->cacheQuery) {
                throw new \Exception("No cached query result found.");
            }
        
            return $this->cacheQuery->num_rows;
        }

        /**
         * ===========================
         * Helper
         * ===========================
         */
        /**
         * Builds the final SQL query from cached parts.
         *
         * @param  string|false $table - Optional table name.
         * @return string
         * @throws \Exception
         */
        private function buildFinalQuery($table = false) {
            $sql = "";
            if($table) {
                $sql .= $this->cacheSelect;
                $sql .= " FROM " . $this->sanitizeIdentifier($table);
            } else if($this->cacheFrom) {
                $sql .= $this->cacheFrom;
            } else {
                throw new \Exception("Table name not provided.");
            }

            if($this->cacheJoin) {
                $sql .= $this->cacheJoin;
            }
            if($this->cacheWhere) {
                $sql .= $this->cacheWhere;
            }
            if($this->cacheOrderBy) {
                $sql .= $this->cacheOrderBy;
            }
            if($this->cacheLimit) {
                $sql .= $this->cacheLimit;
            }

            return $sql;
        }

        /**
         * Builds the WHERE condition.
         *
         * @param   $condition - Condition to build.
         * @param  bool $useWhere - Use WHERE keyword (default: false).
         */
        private function buildCondition( $condition, bool $useWhere = false) {
            if(is_array($condition)) {
                $conditions = [];
                foreach($condition as $key => $value) {
                    $escapedValue = $this->DBConnection->connection()->real_escape_string($value);
                    $conditions[] = $this->sanitizeIdentifier($key) . " = '$escapedValue'";
                }
                return ($useWhere ? " WHERE " : "") . implode(" AND ", $conditions);
            }
            return $useWhere ? " WHERE " . $condition : $condition;
        }

        /**
         * Sanitizes SQL identifiers (e.g., column or table names).
         *
         * @param  string $identifier - Identifier to sanitize.
         */
        private function sanitizeIdentifier(string $identifier) {
            return preg_replace('/[^a-zA-Z0-9,*_]/', '', $identifier);
        }

        /**
         * Clears all cached query parts.
         *         */
        public function clearCache() {
            $this->cacheQuery = false;
            $this->cacheSelect = false;
            $this->cacheFrom = false;
            $this->cacheWhere = false;
            $this->cacheOrderBy = false;
            $this->cacheLimit = false;
            $this->cacheJoin = false;
        }

    }