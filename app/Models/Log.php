<?php
namespace App\Models;

use App\Classes\RequestFilter\FilterClasses\LogFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Log extends Model
{
    use HasFactory;

    protected $table = 'logs';
    protected $guarded = [];

    /**
     * @return Builder
     */
    private function getTableBuilder(): Builder
    {
        return DB::table($this->table);
    }

    /**
     * @param Request $request
     * @return int
     */
    public function getLogCountBasedOnFilter(Request $request) : int
    {
        return (new LogFilter($request))->filter($this->getTableBuilder())->count();
    }

    /**
     * @param $data
     * @return bool
     */
    public function insertBulkData($data) : bool
    {
        return $this->getTableBuilder()->insert($data);
    }
}
