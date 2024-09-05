<?php

namespace App\Livewire;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
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

final class Recruits extends PowerGridComponent
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
    // return DB::table('staff')->where('graduated', NULL);
    return DB::table('recruit')
      // ->leftJoin('roles', 'staff.role_id', '=', 'roles.id')
      // ->leftJoin('beat_branches', 'staff.beat_branch_id', '=', 'beat_branches.id')
      // ->leftJoin('shifts', 'staff.shift_id', '=', 'shifts.id')
      ->where('approve', 0)
      ->whereNull('recruit.staff_id')
      ->select('recruit.*');
  }

  public function fields(): PowerGridFields
  {
    return PowerGrid::fields()
      ->add('id')
      ->add('first_name')
      ->add('middle_name')
      ->add('last_name')
      ->add('phone_number')
      // ->add('date_of_birth_formatted', fn($model) => Carbon::parse($model->date_of_birth)->age)
      ->add('gender')
      // ->add('address')
      ->add('area')
      ->add('city')
      ->add('state')
      ->add('created_by')
      ->add('note')
      // ->add('branch_name')
      // ->add('shifts_id')
      // ->add('status')
      ->add('recruit_date', fn($model) => Carbon::parse($model->hire_date)->diffForHumans(['options' => Carbon::ONE_DAY_WORDS]))
      // ->add('bank_account')
    ;
  }

  public function columns(): array
  {
    return [
      Column::action('Action'),

      Column::make('First name', 'first_name')
        ->sortable()
        ->searchable(),

      Column::make('Middle name', 'middle_name')
        ->sortable()
        ->searchable(),

      Column::make('Last name', 'last_name')
        ->sortable()
        ->searchable(),



      Column::make('Phone number', 'phone_number')
        ->sortable()
        ->searchable(),


      Column::make('Gender', 'gender')
        ->sortable()
        ->searchable(),

      // Column::make('Address', 'address')
      //   ->sortable()
      //   ->searchable(),

      Column::make('Area', 'area')
        ->sortable()
        ->searchable(),

      Column::make('City', 'city')
        ->sortable()
        ->searchable(),

      Column::make('Brought By', 'created_by'),
      // Column::make('Beat id', 'beat_id'),
      Column::make('Note', 'note'),
      // Column::make('Shifts id', 'shifts_id'),

      Column::make('Recruit date', 'recruit_date_formatted', 'recruit_date')
        ->sortable(),
    ];
  }

  public function filters(): array
  {
    return [
      // Filter::datepicker('date_of_birth'),
      // Filter::datepicker('graduated'),
      Filter::datepicker('recruit_date'),
    ];
  }

  public function edit($rowId): void
  {
    $route = route('staff-view', ['id' => $rowId]);
    $this->dispatchBrowserEvent('redirect', $route);
  }

  public function confirmDelete($rowId): void
  {
    $this->dispatchBrowserEvent('confirmDelete', ['rowId' => $rowId]);
  }

  public function delete($rowId): void
  {
    DB::transaction(function () use ($rowId) {
      DB::table('shifts')->where('staff_id', $rowId)->delete();
      DB::table('staff')->where('id', $rowId)->delete();
    });

    $this->dispatchBrowserEvent('staffDeleted', ['rowId' => $rowId]);
  }

  public function actions($row): array
  {
    return [
      Button::add('edit')
        ->slot('View')
        ->id()
        ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
        ->dispatch('edit', ['rowId' => $row->id]),
      Button::add('delete')
        ->slot('Delete')
        ->id()
        ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
        ->dispatch('confirmDelete', ['rowId' => $row->id]),
    ];
  }

  protected $listeners = [
    'edit' => 'edit',
    'delete' => 'delete',
    'refreshTable' => 'refreshTable',
    'confirmDelete' => 'confirmDelete',
  ];
}
