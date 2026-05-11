<?php

namespace App\Models;

use CodeIgniter\Model;

class PenyakitModel extends Model
{
    protected $table            = 'penyakit';
    protected $primaryKey       = 'id_penyakit';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['kode_penyakit', 'nama_penyakit', 'solusi', 'gambar'];

    public function getAllWithGejalaCount()
    {
        $builder = $this->db->table('penyakit p');
        $builder->select('p.*, COUNT(b.id_gejala) as jumlah_gejala');
        $builder->join('basis_pengetahuan b', 'p.id_penyakit = b.id_penyakit', 'left');
        $builder->groupBy('p.id_penyakit');
        $penyakit = $builder->get()->getResultArray();
        
        foreach ($penyakit as &$p) {
            $gejala = $this->db->table('basis_pengetahuan bp')
                ->select('g.kode_gejala, g.nama_gejala')
                ->join('gejala g', 'g.id_gejala = bp.id_gejala')
                ->where('bp.id_penyakit', $p['id_penyakit'])
                ->get()
                ->getResultArray();
            $p['gejala_list'] = $gejala;
        }
        
        return $penyakit;
    }

    public function getDetailWithGejala($id)
    {
        $penyakit = $this->find($id);
        if (!$penyakit) return null;

        $gejala = $this->db->table('basis_pengetahuan b')
            ->select('g.*, b.mb, b.md, b.cf')
            ->join('gejala g', 'g.id_gejala = b.id_gejala')
            ->where('b.id_penyakit', $id)
            ->get()
            ->getResultArray();

        return [
            'penyakit' => $penyakit,
            'gejala' => $gejala
        ];
    }

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
