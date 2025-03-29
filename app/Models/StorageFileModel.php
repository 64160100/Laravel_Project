<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class StorageFileModel extends Model
{
    
    protected $table = 'Storage_File';
    protected $primaryKey = 'Id_Storage_File';
    public $timestamps = false;

    protected $fillable = [
        'Name_Storage_File',
        'Path_Storage_File',
        'Type_Storage_File',
        'Size',
        'Project_Id',
    ];

    protected $casts = [
        'Size' => 'float',
    ];

    public function getSizeInMB()
    {
        return round($this->Size / (1024 * 1024), 2);
    }

    public function getHumanReadableSize()
    {
        $bytes = $this->Size;
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];
        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }
        return round($bytes, 2) . ' ' . $units[$i];
    }

    public static function createFromUploadedFile(UploadedFile $file, string $path, int $projectId): ?self
    {
        if ($file->getClientMimeType() !== 'application/pdf' && !str_starts_with($file->getClientMimeType(), 'image/')) {
            return null;
        }

        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs($path, $fileName, 'public');

        $sizeInBytes = $file->getSize();

        return self::create([
            'Name_Storage_File' => $fileName,
            'Path_Storage_File' => $filePath,
            'Type_Storage_File' => $file->getClientMimeType(),
            'Size' => $sizeInBytes,
            'Project_Id' => $projectId,
        ]);
    }

    public static function getMaxFileSizeInMB()
    {
        return config('filesystems.max_pdf_size', 10);
    }

    public static function isValidPDFSize(UploadedFile $file)
    {
        $sizeInMB = $file->getSize() / (1024 * 1024);
        return $sizeInMB <= self::getMaxFileSizeInMB();
    }

    public function delete()
    {
        Storage::disk('public')->delete($this->Path_Storage_File);
        return parent::delete();
    }

    public function project()
    {
        return $this->belongsTo(ListProjectModel::class, 'Project_Id', 'Id_Project');
    }
}