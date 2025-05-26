<?php

namespace Modules\Database\Schema;
use Illuminate\Database\Schema\Blueprint as BaseBlueprint;
use Modules\Database\Models\User;

/**
 * @author narnowin195@gmail.com
 */
class Blueprint extends BaseBlueprint
{
    public function user()
    {
        $this->foreignIdFor(User::class, 'created_by', 32, false);
        $this->foreignIdFor(User::class, 'updated_by', 32, true);

        return $this;
    }

    public function foreignIdFor($model, $column = null, $length = 32, $nullable = false)
    {
        if (is_string($model)) {
            $model = new $model;
        }

        $column = $column ?: $model->getForeignKey();

        if ($model->getKeyType() === 'int' && $model->getIncrementing()) {
            if ($length === 64) {
                $columnDefinition = $this->unsignedBigInteger($column);
            } elseif ($length === 32) {
                $columnDefinition = $this->unsignedInteger($column);
            } elseif ($length === 24) {
                $columnDefinition = $this->unsignedMediumInteger($column);
            } elseif ($length === 16) {
                $columnDefinition = $this->unsignedSmallInteger($column);
            } elseif ($length === 8) {
                $columnDefinition = $this->unsignedTinyInteger($column);
            } else {
                $columnDefinition = $this->foreignId($column);
            }

            if ($nullable) {
                $columnDefinition->nullable();
            }

            $this->foreign($column)->references('id')->on($model->getTable())->nullOnDelete();

            return $this;
        }

        if ($length) {
            $columnDefinition = $this->string($column, $length);
            if ($nullable) {
                $columnDefinition->nullable();
            }

            return $columnDefinition;
        }

        $columnDefinition = $this->foreignUuid($column);
        if ($nullable) {
            $columnDefinition->nullable();
        }

        return $columnDefinition;
    }
}
