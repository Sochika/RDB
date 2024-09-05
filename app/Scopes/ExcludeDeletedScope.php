<?

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ExcludeDeletedScope implements Scope
{
  public function apply(Builder $builder, Model $model)
  {
    // Apply the constraint to exclude records where delete = 0
    $builder->where('delete', '!=', 1);
  }
}
