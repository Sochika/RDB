'use strict';

$(function () {
  var dt_user_table = $('.datatables-users');

  if (dt_user_table.length) {
    var dt_user = dt_user_table.DataTable({
      ajax: {
        url: 'assets/json/staff-list.json',
        dataSrc: 'data' // Specify the property that contains the array of data
      },
      columns: [
        { data: 'id' },
        {
          data: 'full_name',
          render: function (data, type, full, meta) {
            // Example rendering with avatar
            var avatar = full.avatar ? '<img src="' + full.avatar + '" class="rounded-circle" alt="Avatar">' : '';
            return avatar + ' ' + data;
          }
        },
        { data: 'role' },
        { data: 'phone_number' },
        {
          data: 'beat',
          render: function (data, type, full, meta) {
            // Example rendering for beat with fallback if empty
            return data ? data : 'N/A';
          }
        },
        {
          data: 'hire_date',
          render: function (data, type, full, meta) {
            // Example rendering for hire date, could use moment.js for better date formatting
            return data;
          }
        },
        {
          data: 'status',
          render: function (data, type, full, meta) {
            // Example rendering for status with statusObj mapping
            var statusObj = {
              0: { title: 'Inactive', class: 'bg-label-secondary' },
              1: { title: 'Active', class: 'bg-label-success' }
            };
            return '<span class="badge ' + statusObj[data].class + '">' + statusObj[data].title + '</span>';
          }
        },
        {
          data: null,
          render: function (data, type, full, meta) {
            // Example rendering for actions column
            return (
              '<div class="btn-group">' +
              '<button class="btn btn-sm btn-outline-primary">View</button>' +
              '<button class="btn btn-sm btn-outline-danger">Delete</button>' +
              '</div>'
            );
          }
        }
      ],
      order: [[1, 'asc']], // Default sorting by full_name ascending
      dom:
        '<"row"' +
        '<"col-md-2"<"ms-n2"l>>' +
        '<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-6 mb-md-0 mt-n6 mt-md-0"fB>>' +
        '>t' +
        '<"row"' +
        '<"col-sm-12 col-md-6"i>' +
        '<"col-sm-12 col-md-6"p>' +
        '>',
      language: {
        sLengthMenu: '_MENU_',
        search: '',
        searchPlaceholder: 'Search User',
        paginate: {
          next: '<i class="ti ti-chevron-right ti-sm"></i>',
          previous: '<i class="ti ti-chevron-left ti-sm"></i>'
        }
      },
      buttons: [
        {
          extend: 'collection',
          className: 'btn btn-label-secondary dropdown-toggle mx-4 waves-effect waves-light',
          text: '<i class="ti ti-upload me-2 ti-xs"></i>Export',
          buttons: ['csv', 'excel', 'pdf', 'print']
        },
        {
          text: '<i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span class="d-sm-inline-block">Add New Staff</span>',
          className: 'add-new btn btn-primary waves-effect waves-light',
          attr: {
            'data-bs-toggle': 'offcanvas',
            'data-bs-target': '#offcanvasAddUser'
          }
        }
      ],
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return 'Details of ' + data['full_name'];
            }
          }),
          type: 'column',
          renderer: function (api, rowIdx, columns) {
            var data = $.map(columns, function (col, i) {
              return col.title !== ''
                ? '<tr data-dt-row="' +
                    col.rowIndex +
                    '" data-dt-column="' +
                    col.columnIndex +
                    '">' +
                    '<td>' +
                    col.title +
                    ':' +
                    '</td> ' +
                    '<td>' +
                    col.data +
                    '</td>' +
                    '</tr>'
                : '';
            }).join('');

            return data ? $('<table class="table"/><tbody />').append(data) : false;
          }
        }
      }
    });
  }
});
