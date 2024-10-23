@extends('layouts.admin')
@section('content')

            <div class="row www">
              <div class="col-md-5 grid-margin stretch-card">
                <!-- Bootstrap carousel -->
                <div class="col-md">
                     <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                      <button
                        type="button"
                        data-bs-target="#carouselExample"
                        data-bs-slide-to="0"
                        class="active"
                        aria-current="true"
                        aria-label="Slide 1"></button>
                      <button
                        type="button"
                        data-bs-target="#carouselExample"
                        data-bs-slide-to="1"
                        aria-label="Slide 2"></button>
                      <button
                        type="button"
                        data-bs-target="#carouselExample"
                        data-bs-slide-to="2"
                        aria-label="Slide 3"></button>
                        <button
                        type="button"
                        data-bs-target="#carouselExample"
                        data-bs-slide-to="3"
                        aria-label="Slide 4"></button>

                    </div>

                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img class="d-block w-100" style="height: 89%" src="../assets/img/elements/m.jpeg" alt="First slide" />
                          </div>
                      <div class="carousel-item active">
                        <img class="d-block w-100" style="height: 89%" src="../assets/img/elements/i.jpeg" alt="First slide" />
                      </div>
                      <div class="carousel-item">
                        <img class="d-block w-100" style="height: 89%" src="../assets/img/elements/y.jpeg" alt="Second slide" />
                       </div>
                      <div class="carousel-item">
                        <img class="d-block w-100" style="height: 89%" src="../assets/img/elements/a.jpeg" alt="Third slide" />
                       </div>

                    </div>
                    <a class="carousel-control-prev" href="#carouselExample" role="button" data-bs-slide="prev">
                      <span class="visually-hidden">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExample" role="button" data-bs-slide="next">
                      <span class="visually-hidden">Next</span>
                    </a>
                  </div>
                </div>
                <!-- Bootstrap crossfade carousel -->
              </div>
              <div class="col-md-6 grid-margin transparent">
                <div class="row">
                  <div class="col-md-6  stretch-card transparent">
                    <div class="card card-tale">
                      <div class="card-body" style="background-color: rgb(124, 207, 255); color:rgb(255, 255, 255)">
                        <p class="mb-4 text"><b>Jumlah Data di Tabel Barang</b></p>
                        <p class="fs-30 mb-2"><h4>{{$barang}}</h4></p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6  stretch-card transparent">
                    <div class="card card-dark-blue">
                      <div class="card-body"  style="background-color: rgb(146, 255, 118); color:rgb(255, 255, 255)">
                        <p class="mb-4"><b>Jumlah Data di Tabel Ruangan</b></p>
                        <p class="fs-30 mb-2"><h4>{{$ruangan}}</h4></p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6  mb-lg-0 stretch-card transparent">
                    <div class="card card-light-blue">
                      <div class="card-body"  style="background-color: rgb(255, 125, 125); color:rgb(255, 255, 255)">
                        <p class="mb-4 "><b>Jumlah Data di Tabel Merk</b></p>
                        <p class="fs-30 mb-2"><h4>{{$merk}}</h4></p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 stretch-card transparent">
                    <div class="card card-light-danger">
                      <div class="card-body"  style="background-color: rgb(209, 124, 255); color:rgb(255, 255, 255)">
                        <p class="mb-4"><b>Jumlah Data di Tabel Kategori</b></p>
                        <p class="fs-30 mb-2"><h4>{{$kategori}}</h4></p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

@endsection
