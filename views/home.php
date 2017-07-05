<main id="home" class="container">
    <section id="lista-publicacao-content"  class="row">
        <header id="lista-publicacao-cabecalho" class="col-xs-12 col-md-12 col-lg-12">
                <section class="titulo col-xs-12 col-sm-4">
                    <h4>Publicações</h4>
                    <?php if( isset($_SESSION['user_id']) ){ ?>
                        <a href="#" class="label label-primary" id="meusPosts">Minhas publicações</a>
                        <a href="#" class="label label-primary" id="listaDefault" style="display:none;">Todas publicações</a>
                    <?php } ?>
                </section>

                <form id="lista-publicao-form" name="FormPostFiltros" class="col-xs-12 col-sm-8 pull-right">
                    <input type="hidden" name="lista" value="default">
                    <section id="lista-quantidade" class="col-xs-12 col-md-2 col-lg-2">
                        <div class="form-group">
                                <select class="select-quantidade form-control">
                                    <option selected="" value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="30">30</option>
                                </select>
                            </div>
                    </section>
                    <section id="lista-ordenacao" class="col-xs-12 col-md-4 col-lg-3">
                            <div class="form-group">
                                <select class="select-ordenacao form-control">
                                    <option selected="" value="default">Ordenar</option>
                                    <option value="DESC">Mais Recente</option>
                                    <option value="ASC">Mais Antigo</option>
                                </select>
                            </div>
                    </section>
                    <section id="lista-data" class="col-xs-12 col-md-3 col-lg-3">
                        <div id="datetimepicker1" class="input-append date input-group">
                            <input data-format="dd/MM/yyyy hh:mm:ss" type="text" class="form-control" />
                            <input type="hidden" id="dataHorario" value="0000-00-00" />
                            <span class="add-on input-group-addon">
                              <i class="fa fa-calendar"  data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                            </span>
                          </div>
                    </section>
                    <a class="btn btn-default" id="resetButton" style="display:none;">Limpar filtros</a>
                </form>
        </header>
        <main id="lista-publicacao-corpo" class="col-xs-12 col-md-12 col-lg-12">
            <div class="row"></div>
        </main>
    </section>
</main>