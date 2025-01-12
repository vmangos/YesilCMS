<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property $wowgeneral
 */
class News_model extends CI_Model
{
    /**
     * News_model constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function insertComment($reply, $newsid, $idsession): bool
    {
        $date = $this->wowgeneral->getTimestamp();

        $data = array(
            'id_new'     => $newsid,
            'commentary' => $reply,
            'date'       => $date,
            'author'     => $idsession
        );

        $this->db->insert('news_comments', $data);

        return true;
    }

    public function removeComment($id): bool
    {
        $this->db->where('id', $id)->delete('news_comments');

        return true;
    }

    public function getComments($idlink): CI_DB_result
    {
        return $this->db->select('*')->where('id_new', $idlink)->get('news_comments');
    }

    public function getNewTitle($id)
    {
        return $this->db->select('title')->where('id', $id)->get('news')->row('title');
    }

    public function getNewImage($id)
    {
        return $this->db->select('image')->where('id', $id)->get('news')->row('image');
    }

    public function getNewDescription($id)
    {
        return $this->db->select('description')->where('id', $id)->get('news')->row('description');
    }

    public function getNewlogDate($id)
    {
        return $this->db->select('date')->where('id', $id)->get('news')->row('date');
    }

    public function getCommentCount($id): int
    {
        return $this->db->select('id')->where('id_new', $id)->get('news_comments')->num_rows();
    }

    public function getNewSpecifyID($id): CI_DB_result
    {
        return $this->db->select('*')->where('id', $id)->get('news');
    }

    public function getNewsList(): CI_DB_result
    {
        return $this->db->select('*')->order_by('id', 'DESC')->limit('4')->get('news');
    }

    public function getExtendedNewsList(): CI_DB_result
    {
        return $this->db->select('*')->order_by('id', 'DESC')->limit('8')->get('news');
    }
}
