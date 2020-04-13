<?php
namespace core;

use model\Note;
use PDO;
use Exception;

class Notes
{
    /**
     * Получить все заметки
     *
     * @param integer $userId
     * @return Note[]
     */
    public static function getNotes(int $userId)
    {
        $db = Db::getDBO();
        try {
            $notes = $db->getAll("SELECT id, user_id as userId, name, description, date FROM notes WHERE user_id = ?", [$userId], PDO::FETCH_CLASS, 'model\Note');
            return $notes;
        } catch (Exception $e) {
            throw new Exception("Произошла неизвестная ошибка");
        }

        return $notes;
    }

    /**
     * Получить заметку по id
     *
     * @param integer $noteId
     * @return Note
     */
    public static function getNote(int $noteId)
    {
        $db = Db::getDBO();
        try {
            $note = $db->getFirst("SELECT * FROM notes WHERE id = ?", [$noteId], PDO::FETCH_CLASS, 'Note');
        } catch (Exception $e) {
            throw new Exception("Произошла неизвестная ошибка");
        }

        return $note;
    }

    /**
     * Добавить заметку
     *
     * @param Note $note
     * @return int
     */
    public static function addNote(Note $note)
    {
        $db = Db::getDBO();
        try {
            $db->exec("INSERT INTO notes (user_id, name, description, date) VALUES (?, ?, ?, ?)", [$note->userId, $note->name, $note->description, $note->date]);
            return $db->getLastInsertId();
        } catch (Exception $e) {
            throw new Exception("Невозможно добавить запись");
        }
    }

    /**
     * Удалить заметку
     *
     * @param int $noteId
     * @return void
     */
    public static function deleteNote(int $noteId)
    {
        $db = Db::getDBO();
        try {
            $db->exec("DELETE FROM notes WHERE id = ?", [$noteId]);
        } catch (Exception $e) {
            throw new Exception("Невозможно удалить запись");
        }
    }

    /**
     * Обновить заметку
     *
     * @param Note $note
     * @return void
     */
    public static function updateNote(Note $note)
    {
        $db = Db::getDBO();
        $sql = "UPDATE notes SET ";
        $changeParams = [];

        if ($note->name)
            $changeParams[] = "name = {$db->quote($note->name)}";

        if ($note->description)
            $changeParams[] = "description = {$db->quote($note->description)}";

        if ($note->date)
            $changeParams[] = "date = {$db->quote($note->date)}";  
            
        $sql .= implode(',', $changeParams);
        $sql .= "WHERE id = {$db->quote($note->id)}";

        try {
            $db->exec($sql);
        } catch (Exception $e) {
            throw new Exception("Невозможно обновить запись");
        }
    }
}
