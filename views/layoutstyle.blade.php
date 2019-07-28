<style>

body {
  overflow-x: hidden;
  background-color: #f5f5f5;
  font-family: 'Montserrat', sans-serif;
  font-size: 14px;
}

#page{margin: -2em 0px 1em 0px}
#mainbar{background-color: #4fd4cb;padding: 1em 1em 3em 1em}
.card{border-top: 2px solid #ffc107;margin-bottom: 1em}
.list-group-flush .list-group-item {  border: 0 !important}

.btn-primary{background-color:#3ba79f;border-color:#3ba79f}
.btn-primary:focus, .btn-primary:focus:active, .btn-primary:active, .btn-primary:hover {background-color: #2c968f !important;border-color: #2c968f!important;}
.btn-primary.focus, .btn-primary:focus {box-shadow: 0 0 0 0.2rem rgba(58, 183, 175, 0.28)!important;}

.menumodul i{
  font-size: 1.3em;
  text-align: center;
  color: #666666;
  margin-right: 0.5em;
  width: 1.3em;
}

.menumodul{
  font-size: 1.1em;
  font-weight: bold;
  padding-left: 2em;
}

.menumodul.selected{
  background-color: #ffedb8
}

.card-header h2{font-size: 1.8em}

h1.sidebar-heading{
  text-align: center;
  text-transform: uppercase;
  font-weight: bold;
  padding: 1em 0.2em;
  font-size: 1.3em;
}

h1.sidebar-heading a{
  color: inherit;
  text-decoration: none;
}

#sidebar-wrapper {
  background-color: #fff;
  min-height: 100vh;
  margin-left: -15rem;
  -webkit-transition: margin .25s ease-out;
  -moz-transition: margin .25s ease-out;
  -o-transition: margin .25s ease-out;
  transition: margin .25s ease-out;
}

#sidebar-wrapper .sidebar-heading {

}

#sidebar-wrapper .list-group {
  width: 15rem;
}

#page-content-wrapper {
  min-width: 100vw;
}

#wrapper.toggled #sidebar-wrapper {
  margin-left: 0;
}

@media (min-width: 768px) {
  #sidebar-wrapper {
    margin-left: 0;
  }

  #page-content-wrapper {
    min-width: 0;
    width: 100%;
  }

  #wrapper.toggled #sidebar-wrapper {
    margin-left: -15rem;
  }
}

.noselect {
  -webkit-touch-callout: none; /* iOS Safari */
    -webkit-user-select: none; /* Safari */
     -khtml-user-select: none; /* Konqueror HTML */
       -moz-user-select: none; /* Firefox */
        -ms-user-select: none; /* Internet Explorer/Edge */
            user-select: none; /* Non-prefixed version, currently
                                  supported by Chrome and Opera */
}
.nowrap{
  white-space: nowrap;
}
</style>
