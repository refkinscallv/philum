How To Use

```php
<?php

use \Philum\Database\MySQLi\MySQLi;

try {
    // Creating an instance of the Database class
    $db = new MySQLi();

    // Example usage of the select() method
    $db->select('id, name')->from('users')->get();
    $results = $db->fetchAll();
    print_r($results);

    // Example usage of the where() method
    $db->select('id, name')->from('users')->where(['id' => 1])->get();
    $user = $db->fetchRow();
    print_r($user);

    // Example usage of the whereIn() method
    $db->select('id, name')->from('users')->whereIn('id', [1, 2, 3])->get();
    $users = $db->fetchAll();
    print_r($users);

    // Example usage of the whereNot() method
    $db->select('id, name')->from('users')->whereNot(['id' => 1])->get();
    $users = $db->fetchAll();
    print_r($users);

    // Example usage of the orderBy() method
    $db->select('id, name')->from('users')->orderBy(['name' => 'ASC'])->get();
    $users = $db->fetchAll();
    print_r($users);

    // Example usage of the limit() method
    $db->select('id, name')->from('users')->limit(5)->get();
    $users = $db->fetchAll();
    print_r($users);

    // Example usage of the join() method
    $db->select('users.id, users.name, profiles.bio')
        ->from('users')
        ->join('profiles', 'users.id = profiles.user_id')
        ->get();
    $users = $db->fetchAll();
    print_r($users);

    // Example usage of the insert() method
    $db->insert('users', ['name' => 'John Doe', 'email' => 'john@example.com']);
    echo "User inserted with ID: " . $db->DBmysqli->insert_id;

    // Example usage of the insertMultiple() method
    $data = [
        ['name' => 'Jane Doe', 'email' => 'jane@example.com'],
        ['name' => 'Mike Smith', 'email' => 'mike@example.com']
    ];
    $db->insertMultiple('users', $data);
    echo "Multiple users inserted.";

    // Example usage of the update() method
    $db->update('users', ['email' => 'john.new@example.com'], ['id' => 1]);
    echo "User updated.";

    // Example usage of the delete() method
    $db->delete('users', ['id' => 2]);
    echo "User deleted.";

    // Example usage of transactions (begin, commit, rollback)
    $db->begin();
    try {
        $db->insert('users', ['name' => 'Transactional User', 'email' => 'trans@example.com']);
        $db->commit();
        echo "Transaction committed.";
    } catch (Exception $e) {
        $db->rollback();
        echo "Transaction rolled back.";
    }

    // Example usage of the rawQuery() method
    $db->rawQuery('SELECT COUNT(*) as user_count FROM users');
    $count = $db->fetchAssoc();
    print_r($count);

} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
```

**Explanation:**
1. **Creating an Instance of the Database**: Creating a `Database` object.
2. **select()**: Selecting columns from a table.
3. **where()**: Adding a WHERE condition.
4. **whereIn()**: Adding a WHERE IN condition.
5. **whereNot()**: Adding a WHERE NOT condition.
6. **orderBy()**: Adding an ORDER BY condition.
7. **limit()**: Adding a limit to the number of results.
8. **join()**: Performing a join with another table.
9. **insert()**: Inserting new data into a table.
10. **insertMultiple()**: Inserting multiple rows of data into a table.
11. **update()**: Updating data in a table.
12. **delete()**: Deleting data from a table.
13. **Transactions (begin, commit, rollback)**: Managing database transactions.
14. **rawQuery()**: Executing a raw SQL query.

Each example includes a call to the relevant method of the `Database` class and handles the results. This demonstrates how the class can be used for various database operations.