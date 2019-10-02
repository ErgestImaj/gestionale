@extends('layouts.app')
@section('title','Dashboard')
@section('content')
   <div class="page-content">
       <div class="page-header">
           <h3 class="page-title">
               Dashboard
           </h3>
       </div>
       <div class="row grid-margin">
           <div class="col-12">
               <div class="card card-statistics">
                   <div class="card-body">
                       <div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
                           <div class="statistics-item">
                               <p>
                                   <i class="icon-sm fa fa-user mr-2"></i>
                                   New users
                               </p>
                               <h2>54000</h2>
                               <label class="badge badge-outline-success badge-pill">2.7% increase</label>
                           </div>
                           <div class="statistics-item">
                               <p>
                                   <i class="icon-sm fas fa-hourglass-half mr-2"></i>
                                   Avg Time
                               </p>
                               <h2>123.50</h2>
                               <label class="badge badge-outline-danger badge-pill">30% decrease</label>
                           </div>
                           <div class="statistics-item">
                               <p>
                                   <i class="icon-sm fas fa-cloud-download-alt mr-2"></i>
                                   Downloads
                               </p>
                               <h2>3500</h2>
                               <label class="badge badge-outline-success badge-pill">12% increase</label>
                           </div>
                           <div class="statistics-item">
                               <p>
                                   <i class="icon-sm fas fa-check-circle mr-2"></i>
                                   Update
                               </p>
                               <h2>7500</h2>
                               <label class="badge badge-outline-success badge-pill">57% increase</label>
                           </div>
                           <div class="statistics-item">
                               <p>
                                   <i class="icon-sm fas fa-chart-line mr-2"></i>
                                   Sales
                               </p>
                               <h2>9000</h2>
                               <label class="badge badge-outline-success badge-pill">10% increase</label>
                           </div>
                           <div class="statistics-item">
                               <p>
                                   <i class="icon-sm fas fa-circle-notch mr-2"></i>
                                   Pending
                               </p>
                               <h2>7500</h2>
                               <label class="badge badge-outline-danger badge-pill">16% decrease</label>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>
       <div class="row">
           <div class="col-md-6 grid-margin stretch-card">
               <div class="card">
                   <div class="card-body">
                       <h4 class="card-title">
                           <i class="fas fa-gift"></i>
                           Orders
                       </h4>
                       <canvas id="orders-chart"></canvas>
                       <div id="orders-chart-legend" class="orders-chart-legend"></div>
                   </div>
               </div>
           </div>
           <div class="col-md-6 grid-margin stretch-card">
               <div class="card">
                   <div class="card-body">
                       <h4 class="card-title">
                           <i class="fas fa-chart-line"></i>
                           Sales
                       </h4>
                       <h2 class="mb-5">56000 <span class="text-muted h4 font-weight-normal">Sales</span></h2>
                       <canvas id="sales-chart"></canvas>
                   </div>
               </div>
           </div>
       </div>
       <div class="row">
           <div class="col-md-4 grid-margin stretch-card">
               <div class="card">
                   <div class="card-body d-flex flex-column">
                       <h4 class="card-title">
                           <i class="fas fa-chart-pie"></i>
                           Sales status
                       </h4>
                       <div class="flex-grow-1 d-flex flex-column justify-content-between">
                           <canvas id="sales-status-chart" class="mt-3"></canvas>
                           <div class="pt-4">
                               <div id="sales-status-chart-legend" class="sales-status-chart-legend"></div>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
           <div class="col-md-4 grid-margin stretch-card">
               <div class="card">
                   <div class="card-body">
                       <h4 class="card-title">
                           <i class="far fa-futbol"></i>
                           Activity
                       </h4>
                       <ul class="solid-bullet-list">
                           <li>
                               <h5>4 people shared a post
                                   <span class="float-right text-muted font-weight-normal small">8:30 AM</span>
                               </h5>
                               <p class="text-muted">It was an awesome work!</p>
                               <div class="image-layers">
                                   <div class="img-sm profile-image-text bg-warning rounded-circle image-layer-item">M</div>
                                   <img class="img-sm rounded-circle image-layer-item" src="images/faces/face3.jpg" alt="profile"/>
                                   <img class="img-sm rounded-circle image-layer-item" src="images/faces/face5.jpg" alt="profile"/>
                                   <img class="img-sm rounded-circle image-layer-item" src="images/faces/face8.jpg" alt="profile"/>
                               </div>
                           </li>
                           <li>
                               <h5>Stella posted in a group
                                   <span class="float-right text-muted font-weight-normal small">11:40 AM</span>
                               </h5>
                               <p class="text-muted">The team has done a great job</p>
                           </li>
                           <li>
                               <h5>Dobrick posted in material
                                   <span class="float-right text-muted font-weight-normal small">4:30 PM</span>
                               </h5>
                               <p class="text-muted">Great work. Keep it up!</p>
                           </li>
                       </ul>
                       <div class="border-top pt-3">
                           <div class="d-flex justify-content-between">
                               <button class="btn btn-outline-dark">More</button>
                               <button class="btn btn-primary btn-icon-text">
                                   Add new task
                                   <i class="btn-icon-append fas fa-plus"></i>
                               </button>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
           <div class="col-md-4 grid-margin stretch-card">
               <div class="card">
                   <div class="card-body d-flex flex-column">
                       <h4 class="card-title">
                           <i class="fas fa-tachometer-alt"></i>
                           Daily Sales
                       </h4>
                       <p class="card-description">Daily sales for the past one month</p>
                       <div class="flex-grow-1 d-flex flex-column justify-content-between">
                           <canvas id="daily-sales-chart" class="mt-3 mb-3 mb-md-0"></canvas>
                           <div id="daily-sales-chart-legend" class="daily-sales-chart-legend pt-4 border-top"></div>
                       </div>
                   </div>
               </div>
           </div>
       </div>

   </div>
@endsection
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js"></script>
    <script src="{{asset('js/dashboard.js')}}"></script>
@endpush
