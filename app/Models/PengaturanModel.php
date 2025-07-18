<?php

namespace App\Models;

use CodeIgniter\Model;

class PengaturanModel extends Model
{
    protected $table         = 'pengaturan';
    protected $primaryKey    = 'kunci';
    protected $allowedFields = ['kunci', 'nilai'];
    public    $timestamps    = false;

    /**
     * Ambil nilai dari 1 kunci pengaturan
     */
    public function get(string $kunci): ?string
    {
        $row = $this->find($kunci);
        return $row['nilai'] ?? null;
    }

    /**
     * Ambil banyak pengaturan sekaligus dalam bentuk key => value
     */
    public function getMany(array $keys): array
    {
        $result = $this->whereIn('kunci', $keys)->findAll();
        $assoc = [];
        foreach ($result as $row) {
            $assoc[$row['kunci']] = $row['nilai'];
        }
        return $assoc;
    }

    /**
     * Ambil seluruh pengaturan dalam bentuk asosiatif key => value
     */
    public function getAllAsKeyValue(): array
    {
        $result = $this->findAll();
        $assoc = [];
        foreach ($result as $row) {
            $assoc[$row['kunci']] = $row['nilai'];
        }
        return $assoc;
    }

    // Untuk menyimpan satu pengaturan
    public function saveSetting(string $kunci, string $nilai): bool
    {
        return $this->save(['kunci' => $kunci, 'nilai' => $nilai]);
    }

    // Untuk menyimpan banyak pengaturan sekaligus
    public function saveManySettings(array $data): bool
    {
        foreach ($data as $kunci => $nilai) {
            $this->save(['kunci' => $kunci, 'nilai' => $nilai]);
        }
        return true;
    }
}
