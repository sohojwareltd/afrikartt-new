<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap/bootstrap.min.css') }}">

    {{-- <link rel="stylesheet" href="{{ asset('assets/css/plugins/simple-line-icons.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Forum&display=swap" rel="stylesheet"> 

    <title>Document</title>

</head>
<body>
    {{-- header-section  --}}
    <div class="">
      <nav class="navbar nav-c navbar-expand-lg py-3 ">
        <div class="container-fluid ">
          <div class="col-2">
            <a class="navbar-brand" href="#">
              Royalit E-commerce
            </a>
          </div>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fa fa-bars" aria-hidden="true"></i>

          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="col-9">
              <div class="search d-flex justify-content-end align-items-center">
                  <div class="input-group">
                      <button class="header-search-box-categories dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Categories</button>
                      <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Action before</a></li>
                        <li><a class="dropdown-item" href="#">Another action before</a></li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                        
                      </ul>
                      <input type="text" class="form-control" aria-label="Text input with 2 dropdown buttons">
                      <button class=" btn btn-src" type="submit"><i class="fa fa-search px-2" aria-hidden="true"></i></button>
                      
                    </div>
              </div>
          </div>
            <div class="col-3 d-flex flex-row-reverse">
              <div class="extra mt-1">
                  <a href="login-register.html" class="header-action-account"
                  >Login / SignUp</a
                >
                
                
                <button
                  class="header-action-cart mt-1"
                  type="button"
                  data-bs-toggle="offcanvas"
                  data-bs-target="#offcanvasWithCartSidebar"
                  aria-controls="offcanvasWithCartSidebar"
                >
                  <i class="fa fa-shopping-cart"></i>
                  <span class="cart-count">01</span>
                </button>
                <a class="header-action-wishlist mt-1" href="shop-wishlist.html">
                  <i class="fa fa-bell"></i>
              </a>
              </div>
          </div>
        </div>
      </div>
      

      </nav>
      <div class="nav-scroller   ">
        <nav class="nav d-flex d-flex justify-content-evenly">
          <a class="p-2 link-secondary" href="#">Trending</a>
          <a class="p-2 link-secondary" href="#">Best Seller</a>
          <a class="p-2 link-secondary" href="#">Saves</a>
          <a class="p-2 link-secondary " href="#">
            <i class="fa-solid fa-location-dot "></i>
            Receiving method <br> Hudson, 12534

          </a>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle link-secondary" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Receiving method
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
          </li>
          <a class="p-2 link-secondary" href="#"> Filter <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
</svg>
          </a>
          <a class="p-2 link-secondary" href="#">Help <i class="fa-regular fa-circle-question"></i>
          </a>
  
        </nav>
      </div>
    </div>
    {{-- Hero Section --}}
    <div id="carouselExampleControls" class="carousel slide mt-5" data-bs-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="https://s3-alpha-sig.figma.com/img/2de0/0cbb/fc8e1ced7a7e2cba60acd3aa5f52b688?Expires=1676851200&Signature=hJ5d4Wmrz-iDmmwIuW9uCF9KwFl6PgjwVZnIumBPovRtXA5zfS98ze7NLCkGpRzob7u8yPXjX2UP3R7XroaP2JlIpz1aiuEinY3YVkwS1wkVh-hlWdNIkK4YQ4clW6vD9XMzckovAzPRJOcZdV72joXMh04vh7ZcNsLqIuYBDYADC456JQmDQHhzw-onYMbTK3NDdPWY47dILdwRikuK1p-DYvtvwxlOtJJWLyph8fs28Nk3SBaK7ZDjm-vjiR6GVFsfwQNV-p9FunxEYj2q~XPNtdABlo9FKMOHonUfTxHv9jekFhgyqxT3bu81s~VdGVM02SOsfasfEw-uuiKc7w__&Key-Pair-Id=APKAQ4GOSFWCVNEHN3O4" class="d-block w-100" alt="...">
          </div>
          <div class="carousel-item">
            <img src="https://s3-alpha-sig.figma.com/img/2de0/0cbb/fc8e1ced7a7e2cba60acd3aa5f52b688?Expires=1676851200&Signature=hJ5d4Wmrz-iDmmwIuW9uCF9KwFl6PgjwVZnIumBPovRtXA5zfS98ze7NLCkGpRzob7u8yPXjX2UP3R7XroaP2JlIpz1aiuEinY3YVkwS1wkVh-hlWdNIkK4YQ4clW6vD9XMzckovAzPRJOcZdV72joXMh04vh7ZcNsLqIuYBDYADC456JQmDQHhzw-onYMbTK3NDdPWY47dILdwRikuK1p-DYvtvwxlOtJJWLyph8fs28Nk3SBaK7ZDjm-vjiR6GVFsfwQNV-p9FunxEYj2q~XPNtdABlo9FKMOHonUfTxHv9jekFhgyqxT3bu81s~VdGVM02SOsfasfEw-uuiKc7w__&Key-Pair-Id=APKAQ4GOSFWCVNEHN3O4" class="d-block w-100" alt="...">
          </div>
          <div class="carousel-item">
            <img src="https://s3-alpha-sig.figma.com/img/2de0/0cbb/fc8e1ced7a7e2cba60acd3aa5f52b688?Expires=1676851200&Signature=hJ5d4Wmrz-iDmmwIuW9uCF9KwFl6PgjwVZnIumBPovRtXA5zfS98ze7NLCkGpRzob7u8yPXjX2UP3R7XroaP2JlIpz1aiuEinY3YVkwS1wkVh-hlWdNIkK4YQ4clW6vD9XMzckovAzPRJOcZdV72joXMh04vh7ZcNsLqIuYBDYADC456JQmDQHhzw-onYMbTK3NDdPWY47dILdwRikuK1p-DYvtvwxlOtJJWLyph8fs28Nk3SBaK7ZDjm-vjiR6GVFsfwQNV-p9FunxEYj2q~XPNtdABlo9FKMOHonUfTxHv9jekFhgyqxT3bu81s~VdGVM02SOsfasfEw-uuiKc7w__&Key-Pair-Id=APKAQ4GOSFWCVNEHN3O4" class="d-block w-100" alt="...">
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
      {{-- Category --}}
      <div class="container exlpore">
        <div class="col-auto text-center p-2" >
            <p style="font-size: 40px">Explore Shops</p>
            <div class="row row-cols-1 row-cols-md-5 g-4">
                <div class="col">
                    <div class="card cardm">
                      <img src="https://s3-alpha-sig.figma.com/img/f504/c8e9/e805278210eb89d6ba8ca7c99c0456b5?Expires=1676851200&Signature=eFql6-svNkYjfdcvhjt9vFS-bbjXdejJMNd6CltNU18I0UjRgKBpBPH0j0B9h~Yixzc5CMtw1BCM2A3Y-m4N5A11CNpTeMoLp~bpLv7us1zY1VE90xJcPTwJI7OwYiRcynsrEPoEJ2BmoQ0QEDjLB7dwKSkob8Vspf-95d5WCCZ7wLLf1o53GW479U1pFxMQ-u2cFQHarEWobdHmbt97jW8IGP9kXSSR5zy~n3pH8jTUfNCNVHB0RhEYAuV3UBAWbcwPntumpthn07DqQU51ZdeZGS0i-ACjmw55DD46v2DTsxRHNUHGz2G3QArQCoLuTVAK0hRYgPbcAfmJBSXqYA__&Key-Pair-Id=APKAQ4GOSFWCVNEHN3O4" class="card-img-top " alt="...">
                      
                        
                        {{-- <p class="card-text">This is a short card.</p> --}}
                      
                    </div>
                    <p class="card-title p-3" style="font-size: 20px">Apparels</p>
                  </div>
                <div class="col">
                    <div class="card cardm ">
                      <img src="https://s3-alpha-sig.figma.com/img/998f/1e1a/08d53be70a8d71f07e7592368a9fc3a1?Expires=1676851200&Signature=dW1YBqgOIjg9llv5svvZLs6DVJPY4ARCt36TmHeknapAb90DFvcO3MKzhjolYayRdCSFjtxqe3plSBeS2UbWkX8RB2QCGg0-jbS8sEH3VCIqMe9fVOzla48SFMAW0-20BW0WtRkAdNq2mHtTZ~abeu9YsJZJ74~5FfJDSxKWiQGC~PHZ3ASHHeVOARoQ07QOnB3YwfL4a10JTeaYf~ON8t3WFva8fzTRJqrfz42BdvtisMlHRdEjivYSNDFtQOQb1CgPlsLmcxHaOcO8L~KlKqI22TLFHuLY-LIh2nFzG76M45ss7PtfUapbFNNHH90kEtGdNaIxQNxUcXCZ51iFkw__&Key-Pair-Id=APKAQ4GOSFWCVNEHN3O4" class="card-img-top " alt="...">
                      
                        
                        {{-- <p class="card-text">This is a short card.</p> --}}
                      
                    </div>
                    <p class="card-title p-3" style="font-size: 20px">Beauty</p>
                  </div>
                <div class="col">
                    <div class="card cardm">
                      <img src="https://s3-alpha-sig.figma.com/img/2385/7333/ce8c517458be371ea5a001478372a068?Expires=1676851200&Signature=HPUC2dQ3sN-IDsqYZHcraOl-67-0QAABxFy2GiuObeoy5Ppu1FMVceDOb~-5EqvBwTHuHmtB06dGRTR25Y9Fiw62EN5GTAAx1UMydhg-5RS4UQtnR6a2~j~OthSDc9FbXlr6b9nZYsN70VH0V-xhCxuFCNrB-QAD6d4FIKM0uj2o58F0G5BgwBLTGwfSI~pW2-VyIqOBj3rzAFsr5zmUjKM3pqfzqH0XMGtNufRy6k88dxeZfCpftWz89BQRGlrOLGAD4i43OVeNsdY7AEJwACjPLRAJrP8dfUrE1JyedxytNdv92-IImpcu1CKXYrJkc70GbINhOVhtf9Ti05gBDQ__&Key-Pair-Id=APKAQ4GOSFWCVNEHN3O4" class="card-img-top " alt="...">
                      
                        
                        {{-- <p class="card-text">This is a short card.</p> --}}
                      
                    </div>
                    <p class="card-title p-3" style="font-size: 20px">Electronics</p>
                  </div>
                <div class="col">
                    <div class="card cardm">
                      <img src="https://s3-alpha-sig.figma.com/img/8256/9ebf/b4e770b9e2300469e3a6b039fe7dad3e?Expires=1676851200&Signature=aEFMsOAEt55VHUpkVR~3IrXx0u4YHj51zCt7o8cLMw9reSkYna9gVW6K-2yJg5kyLy30aMP4pCmBnnDUmsTliGG5V~gh6z6tsFFRBR5Lcx2sOgkIT6y~WFK7YXAJJnL1H~fvaiAhejWAEgk~S~BYZZWA2ip-w6bzamzlm00ABUqYjmxQbNUgYT04V8tRDw9PJHNxOcRgI4WL9GVLuhnZk4061lJhtZMwpHT4nMsfID2sLM6aomCKfsEvSspAjjvj7gv5UtCdB3d0l0kNwK0Jrl1NWmYQRBGZhaPS6GrbihagJNAin1IMMDO2PDe1t~8kvFhmV-TgdocXG-OyeoSUpw__&Key-Pair-Id=APKAQ4GOSFWCVNEHN3O4" class="card-img-top " alt="...">
                      
                        
                        {{-- <p class="card-text">This is a short card.</p> --}}
                      
                    </div>
                    <p class="card-title p-3" style="font-size: 20px">Food</p>
                  </div>
                <div class="col">
                    <div class="card cardm">
                      <img src="https://s3-alpha-sig.figma.com/img/9010/ca6f/53818340bed91b51fe2187106a723d25?Expires=1676851200&Signature=NUns~SA4y7m1o5NNEHp3YH7eIcLTZOJqYLpILiJ1d0luFiPegUGyGe50wJB2es98JDJ3eA8pNbAMMT3cM3kpxgnxqvA4n~GPH~Uv~4eYZtORoHFMyBKkDwzBDVSFjAucZRQSnIzYOJa~eypewrxrijA9FbX6n1AVdCXLqIBo51POX2IXv7ntx5p6EdVyCRMrSIO1OIB5nUgRxXnuseTPWbB9lbOKQWUWZ6m5EtLNR34AJVX9lR3wxaEAv1NiGOfdCueTEJO5UqJ7r0bbOKjB72QQdKW~6cpOebbRfXXitD3vJnKCeTpp7t8uzUy8ZmcH072KhZqhW7~BKW3jPoDSKw__&Key-Pair-Id=APKAQ4GOSFWCVNEHN3O4" class="card-img-top " alt="...">
                      
                        
                        {{-- <p class="card-text">This is a short card.</p> --}}
                      
                    </div>
                    <p class="card-title p-3" style="font-size: 20px">Home Furnish</p>
                  </div>
        </div>

      </div>
      {{-- Trending --}}
      <div class="container">
        <div class="headline d-flex">
          <div class="col-6 "><p class="inter" style="font-size: 30px;">Trending in your area</p></div>
          <div class="col-6  d-flex flex-row-reverse"><a href="#"><p class="inter" style="font-size: 25px;">View All ></p></a></div>
        </div>
        <div class="content">
          <div class="row row-cols-1 row-cols-md-6 g-2">
            <div class="col">
              <div class="card cardb">
                <img src="https://s3-alpha-sig.figma.com/img/1a36/134f/903c7c5b8f615fb4502a7e369f5afcd9?Expires=1676851200&Signature=oDHXhHBl3shV~PW5D2cGuPRa4xgIJYd517Dlio3586rpfYBxg37gYKzpn8xLeSuHdfLHwcUGYlPEGQ57bENL7lSFo2lc46JsTDCT5yPazibwL9x6eGEhx1ALVFq2xK8-BeGuJrXrBLw3uaCo2qtwcSzur4qrZ8kNVxAZxdUNHwoxykk2KsDspD6m532BY6cFL5KIQQf0bGdZCjG-Bx1RaobH7zZcHPNDaKAKd2Ze2KdhQ0dTObaxh3AJt2w0EdHXyn9wf7ZamxrKyXTZG8CTUFTP50NUiyu~MpBKoN3eyL0LdxLOgNSHfogYKeMQqwHWb4ZA6xoMbD7Px0G82Jn3yA__&Key-Pair-Id=APKAQ4GOSFWCVNEHN3O4" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title inter" style="font-size: 15px">RYSE Pre-workout</h5>
                  <p class="card-text inter" style="font-size: 12px">Pump, Energy, and Strength| with Caffeine, Vitacholine, Nitrates, and Theobromine</p>
                </div>
              </div>
            </div>
            <div class="col">
              <div class="card cardb">
                <img src="https://s3-alpha-sig.figma.com/img/c58a/5db4/09eac72f55f52c58632fbb66786d8fce?Expires=1676851200&Signature=i6MsB-KZjNjUh~UIZMzE0qAvqOlysNjotqrm7Pt64-BSrkO8j-63xJxlYiKbWSBmsC2Uf-lxxq22d6Kpg0ktdZogCWHrHARbmv7s0iXEKT58XqUkZYc-baAwtOVLOf2tEYg59ITd25Dz7eIUz6L6oKiqNoWrawVJxY9UCXuOkhYgFJzr7ntCr7aBWYZD~KgvoMHrcGlQ5pw~rJJ31DYGR-z0OgpNEhvcsS1aXfYg9HgVP5RgUkzbiayAVUO7WlErciX~XCdd-wFtgdQ4kQ7XTd3LrMZ1zMO1PUrjXta2GUkC0yljMRVGFHi~p1T3ir9OgUjySRE09bpwF0qvPiubtw__&Key-Pair-Id=APKAQ4GOSFWCVNEHN3O4" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title inter" style="font-size: 15px">RYSE Pre-workout</h5>
                  <p class="card-text inter" style="font-size: 12px">Pump, Energy, and Strength| with Caffeine, Vitacholine, Nitrates, and Theobromine</p>
                </div>
              </div>
            </div>
            <div class="col">
              <div class="card cardb">
                <img src="https://s3-alpha-sig.figma.com/img/e1c8/c640/ee768f13232a687a4e0bbe5a4c0c3af9?Expires=1676851200&Signature=bySCtn8rOqmQxQIuOJkWk32-yDoq55iflfj19NqCO2u3z~8p49iNwMtqUAyddGrM8ckVyf~Mf8hUOvAwUsWoZWTqj9Pp7iWhUleEhjbVVusiB1KidlqFM6rXxip0UZmPUyaPcd6G8k2Gq93arCfhYyTJ~9~2EpGbVTQuT5WIIkBYd6cWvj-UseiXbnlQp8ZXTOGPlbwspTCyk51TwPCklGM0TNS2-tbAFlZoBT0UCm9HlT1XO8UDVyvKNlJYM31lmWFIxbDyaDigkO485dYK1GRo9W0EVdufp8fXwCGTfbY3ir4hwju0xfkKGdd1YuOlAItYCxRwdqi9d-s6NRmACw__&Key-Pair-Id=APKAQ4GOSFWCVNEHN3O4" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title inter" style="font-size: 15px">RYSE Pre-workout</h5>
                  <p class="card-text inter" style="font-size: 12px">Pump, Energy, and Strength| with Caffeine, Vitacholine, Nitrates, and Theobromine</p>
                </div>
              </div>
            </div>
            <div class="col">
              <div class="card cardb">
                <img src="https://s3-alpha-sig.figma.com/img/de69/0a8e/8d0c8e5ec9277950c2c00a3656650247?Expires=1676851200&Signature=aJI8yvDIxjUhUEu2cSYbYqMqnl59Ej-ybVsFQ2MyDqO4PGc7FYe7JXEeSRHBE5LS5NoMs8xlKUlzLvPYP62MKawAxCrijZxJkOHm0SH6BovZRPAkLMdaNmPSA2vOLCmvWPxrNyeAI0Tl1eSNEi7jsEoOVlvOrQZgIlUKnz4fnaVxnfBbKGfXqxGGkHHP2KYrp~lili4oiSycad9QPy8oeR-IosiZ6kAUYKOo4y92viVQFog9HeRy0XuzMTvIpKgxL2hJCdcgkpXxZM68Kjmd6A1FBVGudio9kWhIYjfRHFj2jZ9H6~vMvnjylBTA7kc6tVK5uHfe-xw7W9e-MK7q5A__&Key-Pair-Id=APKAQ4GOSFWCVNEHN3O4" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title inter" style="font-size: 15px">RYSE Pre-workout</h5>
                  <p class="card-text inter" style="font-size: 12px">Pump, Energy, and Strength| with Caffeine, Vitacholine, Nitrates, and Theobromine</p>
                </div>
              </div>
            </div>
            <div class="col">
              <div class="card cardb">
                <img src="https://s3-alpha-sig.figma.com/img/a74e/8d19/540f32a6fe398f231c6a25575f23fd62?Expires=1676851200&Signature=lWyCp4cmQIUaqdAw3f-j7kL7RpheH6eJJMB3c3ZrXWLW3bh6mES6meVERLPqBxX9FlrdHEYwJpqosB73HDC9WSuFxJpV3n-8iNPR3vDUHcJHqp7Fz4FCe2o90sDsrH5Mp6KhS54Y0SkK01LQhbLCMFjEhxVHCw0PfSIhEK9s53bxETr1Ost-t7XkXNUIW46TgBWMwSLW~aeYJwDOoK8Spl9tjq4TmJijixuvCR1Bo6uqQrgfoNXK9yTewoeKM1fiydX5-Z7351GT3b0tm41EgTGpeJ1oXgWs0pBFhGYV6vChh-wyAaaq4GyYFyAT-1jEyeSUNb3ij7GRc3ewA4fWMQ__&Key-Pair-Id=APKAQ4GOSFWCVNEHN3O4" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title inter" style="font-size: 15px">RYSE Pre-workout</h5>
                  <p class="card-text inter" style="font-size: 12px">Pump, Energy, and Strength| with Caffeine, Vitacholine, Nitrates, and Theobromine</p>
                </div>
              </div>
            </div>
            <div class="col">
              <div class="card cardb">
                <img src="https://s3-alpha-sig.figma.com/img/74dc/a5ca/f5fd882578477f7398349d65a1f6eb5d?Expires=1676851200&Signature=HmIL1rukA8FAakw5x35FIEMpJBLkIG0ailsW55UaremLvtezsc84ropgyzpKsQ2hpWsfEEbO5hfdmNJvcaBuMi0dqMUIv7iY0sPGSKvnKEHh-0quWO8ytee8olMxrzR0uvMnGFf62-Vyw3kyKXlhv9z8CyY9tzSZ0QoZf~9Xz8s26tkI1nO0~GKmKYwx07KsS-6kk1DNjjVayWRUP4ZttrKsw-tEfVKyIaBSlHfuMdCL-~NlMDI2jVAOki5fmK1l7860z9iVlZeaSs8qQQ8C8XMYUtS7tjVOMgHYGZ~Iq9Mz1Q1UIUWUrym2iDfiLq7c2tEj0xptRmdcdoR-lyHm6A__&Key-Pair-Id=APKAQ4GOSFWCVNEHN3O4" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title inter" style="font-size: 15px">RYSE Pre-workout</h5>
                  <p class="card-text inter" style="font-size: 12px">Pump, Energy, and Strength| with Caffeine, Vitacholine, Nitrates, and Theobromine</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- Recommended --}}
      <div class="container">
        <div class="headline d-flex">
          <div class="col-6 "><p class="inter" style="font-size: 30px;">Recommended for you</p></div>
          <div class="col-6  d-flex flex-row-reverse"><a href="#"><p class="inter" style="font-size: 25px;">View All ></p></a></div>
        </div>
        <div class="content " style="background-color: #F5F5F5">
          <div class="row row-cols-1 row-cols-md-6 g-2">
            <div class="col">
              <div class="card cardc">
                <img src="https://s3-alpha-sig.figma.com/img/1a36/134f/903c7c5b8f615fb4502a7e369f5afcd9?Expires=1676851200&Signature=oDHXhHBl3shV~PW5D2cGuPRa4xgIJYd517Dlio3586rpfYBxg37gYKzpn8xLeSuHdfLHwcUGYlPEGQ57bENL7lSFo2lc46JsTDCT5yPazibwL9x6eGEhx1ALVFq2xK8-BeGuJrXrBLw3uaCo2qtwcSzur4qrZ8kNVxAZxdUNHwoxykk2KsDspD6m532BY6cFL5KIQQf0bGdZCjG-Bx1RaobH7zZcHPNDaKAKd2Ze2KdhQ0dTObaxh3AJt2w0EdHXyn9wf7ZamxrKyXTZG8CTUFTP50NUiyu~MpBKoN3eyL0LdxLOgNSHfogYKeMQqwHWb4ZA6xoMbD7Px0G82Jn3yA__&Key-Pair-Id=APKAQ4GOSFWCVNEHN3O4" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title inter" style="font-size: 14px">DIY Necklaces</h5>
                  <h3>$15.00</h3>
                  <p class="card-text inter" style="font-size: 10px">Pump, Energy, and Strength| with Caffeine, Vitacholine, Nitrates, and Theobromine</p>
                  <div class="d-flex align-items-center">
                    <div class="col-6 d-flex align-items-center">
                      <div class="rating d-flex">
                        <i class="fa-solid fa-star fa-xs"></i>
                        <i class="fa-solid fa-star fa-xs"></i>
                        <i class="fa-solid fa-star fa-xs"></i>
                        <i class="fa-solid fa-star fa-xs"></i>
                        <i class="fa-solid fa-star fa-xs"></i>
                      </div>
                      <div class="num"> <p>&nbsp;5.00</p></div>
                    </div>
                    <div class="col-6 d-flex flex-row-reverse"><i class="fa-solid fa-bag-shopping"></i></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col">
              <div class="card cardc">
                <img src="https://s3-alpha-sig.figma.com/img/1a36/134f/903c7c5b8f615fb4502a7e369f5afcd9?Expires=1676851200&Signature=oDHXhHBl3shV~PW5D2cGuPRa4xgIJYd517Dlio3586rpfYBxg37gYKzpn8xLeSuHdfLHwcUGYlPEGQ57bENL7lSFo2lc46JsTDCT5yPazibwL9x6eGEhx1ALVFq2xK8-BeGuJrXrBLw3uaCo2qtwcSzur4qrZ8kNVxAZxdUNHwoxykk2KsDspD6m532BY6cFL5KIQQf0bGdZCjG-Bx1RaobH7zZcHPNDaKAKd2Ze2KdhQ0dTObaxh3AJt2w0EdHXyn9wf7ZamxrKyXTZG8CTUFTP50NUiyu~MpBKoN3eyL0LdxLOgNSHfogYKeMQqwHWb4ZA6xoMbD7Px0G82Jn3yA__&Key-Pair-Id=APKAQ4GOSFWCVNEHN3O4" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title inter" style="font-size: 14px">DIY Necklaces</h5>
                  <h3>$15.00</h3>
                  <p class="card-text inter" style="font-size: 10px">Pump, Energy, and Strength| with Caffeine, Vitacholine, Nitrates, and Theobromine</p>
                  <div class="d-flex align-items-center">
                    <div class="col-6 d-flex align-items-center">
                      <div class="rating d-flex">
                        <i class="fa-solid fa-star fa-xs"></i>
                        <i class="fa-solid fa-star fa-xs"></i>
                        <i class="fa-solid fa-star fa-xs"></i>
                        <i class="fa-solid fa-star fa-xs"></i>
                        <i class="fa-solid fa-star fa-xs"></i>
                      </div>
                      <div class="num"> <p>&nbsp;5.00</p></div>
                    </div>
                    <div class="col-6 d-flex flex-row-reverse"><i class="fa-solid fa-bag-shopping"></i></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col">
              <div class="card cardc">
                <img src="https://s3-alpha-sig.figma.com/img/1a36/134f/903c7c5b8f615fb4502a7e369f5afcd9?Expires=1676851200&Signature=oDHXhHBl3shV~PW5D2cGuPRa4xgIJYd517Dlio3586rpfYBxg37gYKzpn8xLeSuHdfLHwcUGYlPEGQ57bENL7lSFo2lc46JsTDCT5yPazibwL9x6eGEhx1ALVFq2xK8-BeGuJrXrBLw3uaCo2qtwcSzur4qrZ8kNVxAZxdUNHwoxykk2KsDspD6m532BY6cFL5KIQQf0bGdZCjG-Bx1RaobH7zZcHPNDaKAKd2Ze2KdhQ0dTObaxh3AJt2w0EdHXyn9wf7ZamxrKyXTZG8CTUFTP50NUiyu~MpBKoN3eyL0LdxLOgNSHfogYKeMQqwHWb4ZA6xoMbD7Px0G82Jn3yA__&Key-Pair-Id=APKAQ4GOSFWCVNEHN3O4" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title inter" style="font-size: 14px">DIY Necklaces</h5>
                  <h3>$15.00</h3>
                  <p class="card-text inter" style="font-size: 10px">Pump, Energy, and Strength| with Caffeine, Vitacholine, Nitrates, and Theobromine</p>
                  <div class="d-flex align-items-center">
                    <div class="col-6 d-flex align-items-center">
                      <div class="rating d-flex">
                        <i class="fa-solid fa-star fa-xs"></i>
                        <i class="fa-solid fa-star fa-xs"></i>
                        <i class="fa-solid fa-star fa-xs"></i>
                        <i class="fa-solid fa-star fa-xs"></i>
                        <i class="fa-solid fa-star fa-xs"></i>
                      </div>
                      <div class="num"> <p>&nbsp;5.00</p></div>
                    </div>
                    <div class="col-6 d-flex flex-row-reverse"><i class="fa-solid fa-bag-shopping"></i></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col">
              <div class="card cardc">
                <img src="https://s3-alpha-sig.figma.com/img/1a36/134f/903c7c5b8f615fb4502a7e369f5afcd9?Expires=1676851200&Signature=oDHXhHBl3shV~PW5D2cGuPRa4xgIJYd517Dlio3586rpfYBxg37gYKzpn8xLeSuHdfLHwcUGYlPEGQ57bENL7lSFo2lc46JsTDCT5yPazibwL9x6eGEhx1ALVFq2xK8-BeGuJrXrBLw3uaCo2qtwcSzur4qrZ8kNVxAZxdUNHwoxykk2KsDspD6m532BY6cFL5KIQQf0bGdZCjG-Bx1RaobH7zZcHPNDaKAKd2Ze2KdhQ0dTObaxh3AJt2w0EdHXyn9wf7ZamxrKyXTZG8CTUFTP50NUiyu~MpBKoN3eyL0LdxLOgNSHfogYKeMQqwHWb4ZA6xoMbD7Px0G82Jn3yA__&Key-Pair-Id=APKAQ4GOSFWCVNEHN3O4" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title inter" style="font-size: 14px">DIY Necklaces</h5>
                  <h3>$15.00</h3>
                  <p class="card-text inter" style="font-size: 10px">Pump, Energy, and Strength| with Caffeine, Vitacholine, Nitrates, and Theobromine</p>
                  <div class="d-flex align-items-center">
                    <div class="col-6 d-flex align-items-center">
                      <div class="rating d-flex">
                        <i class="fa-solid fa-star fa-xs"></i>
                        <i class="fa-solid fa-star fa-xs"></i>
                        <i class="fa-solid fa-star fa-xs"></i>
                        <i class="fa-solid fa-star fa-xs"></i>
                        <i class="fa-solid fa-star fa-xs"></i>
                      </div>
                      <div class="num"> <p>&nbsp;5.00</p></div>
                    </div>
                    <div class="col-6 d-flex flex-row-reverse"><i class="fa-solid fa-bag-shopping"></i></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col">
              <div class="card cardc">
                <img src="https://s3-alpha-sig.figma.com/img/1a36/134f/903c7c5b8f615fb4502a7e369f5afcd9?Expires=1676851200&Signature=oDHXhHBl3shV~PW5D2cGuPRa4xgIJYd517Dlio3586rpfYBxg37gYKzpn8xLeSuHdfLHwcUGYlPEGQ57bENL7lSFo2lc46JsTDCT5yPazibwL9x6eGEhx1ALVFq2xK8-BeGuJrXrBLw3uaCo2qtwcSzur4qrZ8kNVxAZxdUNHwoxykk2KsDspD6m532BY6cFL5KIQQf0bGdZCjG-Bx1RaobH7zZcHPNDaKAKd2Ze2KdhQ0dTObaxh3AJt2w0EdHXyn9wf7ZamxrKyXTZG8CTUFTP50NUiyu~MpBKoN3eyL0LdxLOgNSHfogYKeMQqwHWb4ZA6xoMbD7Px0G82Jn3yA__&Key-Pair-Id=APKAQ4GOSFWCVNEHN3O4" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title inter" style="font-size: 14px">DIY Necklaces</h5>
                  <h3>$15.00</h3>
                  <p class="card-text inter" style="font-size: 10px">Pump, Energy, and Strength| with Caffeine, Vitacholine, Nitrates, and Theobromine</p>
                  <div class="d-flex align-items-center">
                    <div class="col-6 d-flex align-items-center">
                      <div class="rating d-flex">
                        <i class="fa-solid fa-star fa-xs"></i>
                        <i class="fa-solid fa-star fa-xs"></i>
                        <i class="fa-solid fa-star fa-xs"></i>
                        <i class="fa-solid fa-star fa-xs"></i>
                        <i class="fa-solid fa-star fa-xs"></i>
                      </div>
                      <div class="num"> <p>&nbsp;5.00</p></div>
                    </div>
                    <div class="col-6 d-flex flex-row-reverse"><i class="fa-solid fa-bag-shopping"></i></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col">
              <div class="card cardc">
                <img src="https://s3-alpha-sig.figma.com/img/1a36/134f/903c7c5b8f615fb4502a7e369f5afcd9?Expires=1676851200&Signature=oDHXhHBl3shV~PW5D2cGuPRa4xgIJYd517Dlio3586rpfYBxg37gYKzpn8xLeSuHdfLHwcUGYlPEGQ57bENL7lSFo2lc46JsTDCT5yPazibwL9x6eGEhx1ALVFq2xK8-BeGuJrXrBLw3uaCo2qtwcSzur4qrZ8kNVxAZxdUNHwoxykk2KsDspD6m532BY6cFL5KIQQf0bGdZCjG-Bx1RaobH7zZcHPNDaKAKd2Ze2KdhQ0dTObaxh3AJt2w0EdHXyn9wf7ZamxrKyXTZG8CTUFTP50NUiyu~MpBKoN3eyL0LdxLOgNSHfogYKeMQqwHWb4ZA6xoMbD7Px0G82Jn3yA__&Key-Pair-Id=APKAQ4GOSFWCVNEHN3O4" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title inter" style="font-size: 14px">DIY Necklaces</h5>
                  <h3>$15.00</h3>
                  <p class="card-text inter" style="font-size: 10px">Pump, Energy, and Strength| with Caffeine, Vitacholine, Nitrates, and Theobromine</p>
                  <div class="d-flex align-items-center">
                    <div class="col-6 d-flex align-items-center">
                      <div class="rating d-flex">
                        <i class="fa-solid fa-star fa-xs"></i>
                        <i class="fa-solid fa-star fa-xs"></i>
                        <i class="fa-solid fa-star fa-xs"></i>
                        <i class="fa-solid fa-star fa-xs"></i>
                        <i class="fa-solid fa-star fa-xs"></i>
                      </div>
                      <div class="num"> <p>&nbsp;5.00</p></div>
                    </div>
                    <div class="col-6 d-flex flex-row-reverse"><i class="fa-solid fa-bag-shopping"></i></div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>

      {{-- all Products --}}
      

    <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>

</body>
</html>