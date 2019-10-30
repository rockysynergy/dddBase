<?php
namespace Orq\DddBase\Repository;

use Orq\DddBase\ModelFactory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use function GuzzleHttp\json_decode;
use function GuzzleHttp\json_encode;
use Orq\DddBase\IllegalArgumentException;
use Orq\DddBase\Repository\RecordsNotExistException;

Abstract class AbstractRepository implements RepositoryInterface
{
    protected static $table = '';
    protected static $class = '';

    public static function save($obj):void
    {
        if (!($obj instanceof static::$class)) {
            throw new IllegalArgumentException('请提供'.static::$class.'实例', 1562225003);
        }

        DB::table(static::$table)->insert($obj->getPersistData());
    }

    public static function saveGetId($obj):int
    {
        if (!($obj instanceof static::$class)) {
            throw new IllegalArgumentException('请提供'.static::$class.'实例', 1571986643);
        }
        return DB::table(static::$table)->insertGetId($obj->getPersistData());
    }

    public static function update($obj):void
    {
        if (!($obj instanceof static::$class)) {
            throw new IllegalArgumentException('请提供'.static::$class.'实例', 1562225033);
        }
        Db::table(static::$table)->where('id', $obj->getId())->update($obj->getPersistData());
    }

    public static function findById(int $id, bool $toObj=FALSE)
    {
        $data = DB::table(static::$table)->find($id);
        if (!$data) {
            throw new RecordsNotExistException("没有找到记录！", 1571988816);
        }
        $data = json_decode(json_encode($data), true);
        if ($toObj) {
            return ModelFactory::make(static::$class, $data);
        } else {
            return $data;
        }
    }

    public static function find(array $where, bool $toObj=FALSE):Collection
    {
        $arr = [];
        $records = DB::table(static::$table)->where($where)->get();
        foreach ($records as $record) {
            $record = json_decode(json_encode($record), true);
            if ($toObj) {
                array_push($arr, ModelFactory::make(static::$class, $record));
            } else {
                array_push($arr, $record);
            }
        }

        return collect($arr);
    }

    public static function findOne(array $where, bool $toObj=FALSE)
    {
        $record = DB::table(static::$table)->where($where)->first();
        if ($record) {
            if ($toObj) {
                return ModelFactory::make(static::$class, json_decode(json_encode($record), true));
            } else {
                return $record;
            }
        }
        return null;
    }

    public static function removeById(int $id)
    {
        DB::table(static::$table)->where('id', $id)->delete();
    }

    public static function delete(array $where)
    {
        DB::table(static::$table)->where($where)->delete();
    }
}
