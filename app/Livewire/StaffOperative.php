<?php

namespace App\Livewire;

use App\Models\Staff;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;
use Illuminate\Support\Arr;

final class StaffOperative extends PowerGridComponent
{
  use WithExport;

  public function setUp(): array
  {
    $this->showCheckBox();

    return [
      Exportable::make('export')
        ->striped()
        ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
      Header::make()->showSearchInput(),
      Footer::make()
        ->showPerPage()
        ->showRecordCount(),
    ];
  }

  public function datasource(): Builder
  {
    return DB::table('staff')->leftJoin('roles', 'staff.role_id', '=', 'roles.id')
      ->leftJoin('beat_branches', 'staff.beat_branch_id', '=', 'beat_branches.id')
      // ->leftJoin('shifts', 'staff.shift_id', '=', 'shifts.id')
      ->whereNull('staff.graduated')
      ->select('staff.*', 'roles.name as role_name', 'beat_branches.name as branch_name');
  }

  public function fields(): PowerGridFields
  {
    return PowerGrid::fields()
      ->add('id')
      ->add('first_name')
      // ->add('middle_name')
      ->add('last_name')
      // ->add('avatar')
      ->add('phone_number')
      ->add('date_of_birth_formatted', fn($model) => Carbon::parse($model->date_of_birth)->age)
      ->add('gender')
      ->add('address')
      ->add('area')
      ->add('city')
      ->add('state')
      ->add('role_name')
      ->add('beat_id')
      ->add('branch_name')
      ->add('shifts_id')
      ->add('status')
      ->add('hire_date_formatted', fn($model) => Carbon::parse($model->hire_date)->diffForHumans(['options' => Carbon::ONE_DAY_WORDS]))
      ->add('bank_account');
  }

  public function columns(): array
  {
    return [
      Column::action('Action'),

      Column::make('First name', 'first_name')
        ->sortable()
        ->searchable(),

      // Column::make('Middle name', 'middle_name')
      //   ->sortable()
      //   ->searchable(),

      Column::make('Last name', 'last_name')
        ->sortable()
        ->searchable(),

      // Column::make('Avatar', 'avatar')
      //   ->sortable()
      //   ->searchable(),

      Column::make('Phone number', 'phone_number')
        ->sortable()
        ->searchable(),

      Column::make('Date of birth', 'date_of_birth_formatted', 'date_of_birth')
        ->sortable(),

      Column::make('Gender', 'gender')
        ->sortable()
        ->searchable(),

      Column::make('Address', 'address')
        ->sortable()
        ->searchable(),

      Column::make('Area', 'area')
        ->sortable()
        ->searchable(),

      Column::make('City', 'city')
        ->sortable()
        ->searchable(),

      Column::make('Role', 'role_name'),
      // Column::make('Beat id', 'beat_id'),
      Column::make('Beat Location', 'branch_name'),
      // Column::make('Shifts id', 'shifts_id'),

      Column::make('Hire date', 'hire_date_formatted', 'hire_date')
        ->sortable(),
    ];
  }

  public function filters(): array
  {
    return [
      Filter::datepicker('date_of_birth'),
      Filter::datepicker('graduated'),
      Filter::datepicker('hire_date'),
    ];
  }

  #[\Livewire\Attributes\On('edit')]
  public function edit($rowId): void
  {
    $route = route('staff-view', ['id' => $rowId]);
    $this->js("window.location.href = '{$route}';");
  }

  public function actions($row): array
  {
    return [
      Button::add('edit')
        ->slot('View')
        ->id()
        ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
        ->dispatch('edit', ['rowId' => $row->id]),

      // Button::add('delete')
      //   ->slot('Delete')
      //   ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
      //   ->dispatch('triggerDelete', ['rowId' => $row->id]) // Trigger JS event

    ];
  }

  // #[\Livewire\Attributes\On('delete')]
  // public function delete($rowId): void
  // {
  //   DB::table('staff')->where('id', $rowId)->delete();

  //   // Optionally, you can use session or toast notifications to notify the user of the successful deletion
  //   session()->flash('message', 'Staff member deleted successfully.');

  //   // Optionally, refresh the data
  //   $this->emit('pg:refresh');
  // }

  // #[\Livewire\Attributes\On('delete')]
  // public function delete($rowId): void
  // {
  //   if (confirm('Are you sure you want to delete this staff member?')) {
  //     DB::table('staff')->where('id', $rowId)->delete();

  //     session()->flash('message', 'Staff member deleted successfully.');

  //     $this->emit('pg:refresh');
  //   }
  // }

  #[\Livewire\Attributes\On('delete')]
  public function delete($rowId): void
  {
    DB::table('staff')->where('id', $rowId)->delete();

    // Optionally, flash a message or emit an event to update the UI
    session()->flash('message', 'Staff member deleted successfully.');

    // Refresh the grid
    $this->emit('pg:refresh');
  }


  /*
    public function actionRules($row): array
    {
       return [
            // Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($row) => $row->id === 1)
                ->hide(),
        ];
    }
    */
}
