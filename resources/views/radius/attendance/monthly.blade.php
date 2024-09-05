@extends('layouts/layoutMaster')

@section('title', 'Sit Rep')

@section('content')
<div class="container">
    <h1>Monthly Attendance for {{ $staff->full_name }} ({{ $month->format('F Y') }})</h1>
    <div class="body d-flex py-lg-3 py-md-2">
      <div class="container-xxl">
          <div class="row align-items-center">
              <div class="border-0 mb-4">
                  <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                      <h3 class="h4 mb-0">Attendance</h3>
                      <div class="col-auto d-flex w-sm-100 mt-2 mt-sm-0">
                          <button type="button" class="btn btn-dark  w-sm-100 me-2" data-bs-toggle="modal" data-bs-target="#editattendance"><i class="icofont-edit me-2 fs-6"></i>Edit Attendance</button>
                          <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                                  Filter
                          </button>
                          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton2">
                              <li><a class="dropdown-item" href="#">All</a></li>
                              <li><a class="dropdown-item" href="#">Today Absent</a></li>
                              <li><a class="dropdown-item" href="#">Week Absent</a></li>
                            </ul>
                      </div>
                  </div>
              </div>
          </div> <!-- Row end  -->
          <div class="row clearfix g-3">
            <div class="col-sm-12">
                  <div class="card mb-3">
                      <div class="card-body">
                          <div class="atted-info d-flex mb-3 flex-wrap">
                                  <div class="full-present me-2">
                                      <i class="icofont-check-circled text-success me-1"></i>
                                      <span>Full Day Present</span>
                                  </div>
                                  <div class="Half-day me-2">
                                     <i class="icofont-wall-clock text-warning me-1"></i>
                                      <span>Half Day Present</span>
                                  </div>
                                  <div class="absent me-2">
                                      <i class="icofont-close-circled text-danger me-1"></i>
                                      <span>Full Day Absence</span>
                                  </div>
                          </div>
                          <div class="table-responsive">
                              <table class="table table-hover align-middle mb-0" style="width:100%">
                                  <thead>
                                      <tr>
                                          <th style="padding-right: 55px;">Employee</th>
                                          <th>1</th>
                                          <th>2</th>
                                          <th>3</th>
                                          <th>4</th>
                                          <th>5</th>
                                          <th>6</th>
                                          <th>7</th>
                                          <th>8</th>
                                          <th>9</th>
                                          <th>10</th>
                                          <th>11</th>
                                          <th>12</th>
                                          <th>13</th>
                                          <th>14</th>
                                          <th>15</th>
                                          <th>16</th>
                                          <th>17</th>
                                          <th>18</th>
                                          <th>19</th>
                                          <th>20</th>
                                          <th>21</th>
                                          <th>22</th>
                                          <th>23</th>
                                          <th>24</th>
                                          <th>25</th>
                                          <th>27</th>
                                          <th>28</th>
                                          <th>29</th>
                                          <th>30</th>
                                          <th>31</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <tr>
                                      <td>
                                          <span class="fw-bold small">Joan Dyer</span>
                                      </td>
                                      <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                      </td>
                                      <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                      </td>
                                      <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                      </td>
                                      <td>
                                                  <i class="icofont-wall-clock text-warning"></i>
                                      </td>
                                      <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                      </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-wall-clock text-warning"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                      </td>
                                      <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                      </td>
                                      <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                      </td>
                                      <td>
                                                  <i class="icofont-wall-clock text-warning"></i>
                                      </td>
                                      <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                      </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>

                                      </tr>
                                      <tr>
                                          <td>
                                              <span class="fw-bold small">Ryan	Randall</span>
                                          </td>
                                          <td>
                                              <i class="icofont-close-circled text-danger"></i>
                                      </td>
                                      <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-close-circled text-danger"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-wall-clock text-warning"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-close-circled text-danger"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-wall-clock text-warning"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>

                                      </tr>
                                      <tr>

                                          <td>
                                              <span class="fw-bold small">Phil	Glover</span>
                                          </td>
                                          <td>
                                              <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-wall-clock text-warning"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-wall-clock text-warning"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>

                                      </tr>
                                      <tr>

                                          <td>
                                              <span class="fw-bold small">Victor Rampling</span>
                                          </td>
                                          <td>
                                              <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-wall-clock text-warning"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-wall-clock text-warning"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-wall-clock text-warning"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>

                                      </tr>
                                      <tr>

                                          <td>
                                              <span class="fw-bold small">Sally Graham</span>
                                          </td>
                                          <td>
                                              <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-wall-clock text-warning"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-wall-clock text-warning"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-wall-clock text-warning"></i>
                                          </td>

                                      </tr>
                                      <tr>

                                          <td>
                                              <span class="fw-bold small">Robert Anderson</span>
                                          </td>
                                          <td>
                                              <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>

                                      </tr>
                                      <tr>

                                          <td>
                                              <span class="fw-bold small">Ryan	Stewart</span>
                                          </td>
                                          <td>
                                              <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-check-circled text-success"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-wall-clock text-warning"></i>
                                          </td>
                                          <td>
                                                  <i class="icofont-wall-clock text-warning"></i>
                                          </td>

                                      </tr>
                                  </tbody>
                              </table>
                          </div>
                      </div>
                  </div>
            </div>
          </div><!-- Row End -->
      </div>
  </div>
</div>
@endsection
