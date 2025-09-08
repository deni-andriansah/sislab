@extends('layouts.admin')
@section('content')

<div class="container-fluid">
  <div class="row">
    <div class="col-lg-5 col-md-12 mb-4">
      <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
          <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
          <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="1" aria-label="Slide 2"></button>
          <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="2" aria-label="Slide 3"></button>
          <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="3" aria-label="Slide 4"></button>
        </div>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img class="d-block w-100" style="height: 300px; object-fit: cover;" src="../assets/img/elements/m.jpeg" alt="First slide" />
          </div>
          <div class="carousel-item">
            <img class="d-block w-100" style="height: 300px; object-fit: cover;" src="../assets/img/elements/i.jpeg" alt="Second slide" />
          </div>
          <div class="carousel-item">
            <img class="d-block w-100" style="height: 300px; object-fit: cover;" src="../assets/img/elements/y.jpeg" alt="Third slide" />
          </div>
          <div class="carousel-item">
            <img class="d-block w-100" style="height: 300px; object-fit: cover;" src="../assets/img/elements/a.jpeg" alt="Fourth slide" />
          </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExample" role="button" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExample" role="button" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </a>
      </div>
    </div>


    <div class="col-lg-7 col-md-12">
      <div class="row">
        <div class="col-md-6 mb-4">
          <div class="card h-100" style="background-color: rgb(124, 207, 255); color: white; border: none;">
            <div class="card-body d-flex flex-column justify-content-center">
              <p class="mb-2"><b>Jumlah Data di Tabel Barang</b></p>
              <h4 class="mb-0">{{$barang}}</h4>
            </div>
          </div>
        </div>
        <div class="col-md-6 mb-4">
          <div class="card h-100" style="background-color: rgb(146, 255, 118); color: white; border: none;">
            <div class="card-body d-flex flex-column justify-content-center">
              <p class="mb-2"><b>Jumlah Data di Tabel Ruangan</b></p>
              <h4 class="mb-0">{{$ruangan}}</h4>
            </div>
          </div>
        </div>
        <div class="col-md-6 mb-4">
          <div class="card h-100" style="background-color: rgb(255, 125, 125); color: white; border: none;">
            <div class="card-body d-flex flex-column justify-content-center">
              <p class="mb-2"><b>Jumlah Data di Tabel Anggota</b></p>
              <h4 class="mb-0">{{$anggota}}</h4>
            </div>
          </div>
        </div>
        <div class="col-md-6 mb-4">
          <div class="card h-100" style="background-color: rgb(209, 124, 255); color: white; border: none;">
            <div class="card-body d-flex flex-column justify-content-center">
              <p class="mb-2"><b>Jumlah Data di Tabel Kategori</b></p>
              <h4 class="mb-0">{{$kategori}}</h4>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <div class="row mt-4">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Grafik Data Statistik</h5>
          <canvas id="dataChart"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  var ctx = document.getElementById('dataChart').getContext('2d');
  var dataChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Barang', 'Ruangan', 'Anggota', 'Kategori'],
      datasets: [{
        label: 'Jumlah Data',
        data: [{{$barang}}, {{$ruangan}}, {{$anggota}}, {{$kategori}}],
        backgroundColor: [
          'rgba(124, 207, 255, 0.7)',
          'rgba(146, 255, 118, 0.7)',
          'rgba(255, 125, 125, 0.7)',
          'rgba(209, 124, 255, 0.7)'
        ],
        borderColor: [
          'rgba(124, 207, 255, 1)',
          'rgba(146, 255, 118, 1)',
          'rgba(255, 125, 125, 1)',
          'rgba(209, 124, 255, 1)'
        ],
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: true,
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>


<style>
  .container-fluid {
    overflow-x: hidden;
  }

  .row {
    margin-left: 0;
    margin-right: 0;
  }

  .card {
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  }

  @media (max-width: 768px) {
    .col-lg-5, .col-lg-7 {
      margin-bottom: 20px;
    }
  }
</style>

@endsection
