<template>
  <div class="container">
    <div class="columns is-gapless">
      <div class="column">
        <div class="panel is-primary">
          <p class="panel-heading">
            Kas: {{ saldo }}
          </p>

          <tabs>
            <tab name="Overzicht" :selected="true">
              <table class="table">
                <tr v-for="row in data">
                  <td v-for="col in row">
                    {{ col }}
                  </td>
                </tr>
              </table>
            </tab>
            <tab name="Storten">
              <form action="/" method="post">
                <div class="form-holder">
                  <div class="field">
                    <label class="label">Naam</label>
                    <div class="control">
                      <div class="select is-fullwidth">
                        <select name="name">
                          <option value="Emiel">Emiel</option>
                          <option value="Gerard">Gerard</option>
                          <option value="Henk">Henk</option>
                          <option value="Martijn">Martijn</option>
                          <option value="Rick">Rick</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="field">
                    <label class="label">Maand</label>
                    <div class="control">
                      <div class="select is-fullwidth">
                        <select name="month">
                          <option value="januari">Januari</option>
                          <option value="februari">Februari</option>
                          <option value="maart">Maart</option>
                          <option value="april">April</option>
                          <option value="mei">Mei</option>
                          <option value="juni">Juni</option>
                          <option value="juli">Juli</option>
                          <option value="augustus">Augustus</option>
                          <option value="september">September</option>
                          <option value="oktober">Oktober</option>
                          <option value="november">November</option>
                          <option value="december">December</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="field">
                    <label class="label">Bedrag</label>
                    <div class="control">
                      <div class="select is-fullwidth">
                        <select name="amount">
                          <option value="0">€ 0,00</option>
                          <option value="10">€ 10,00</option>
                        </select>
                      </div>
                      <span class="icon is-small is-left">
                      <i class="fas fa-globe"></i>
                    </span>
                    </div>
                  </div>
                </div>
                <div class="panel-block">
                  <div class="control">
                    <button class="button is-link is-fullwidth">Versturen</button>
                  </div>
                </div>
              </form>
            </tab>
          </tabs>
        </div>
      </div>
    </div>
  </div>
</template>
<script>

  export default {
    props: {
      saldo: {
        type: String,
        required: false,
        default: 'sdf',
      },
      data: {
        type: Array,
        required: false,
        default: () => []
      },
    },
    mounted() {
      console.log(data);
    },
    methods: {
      switchTab: function (tab) {
        //$('#tabs li').removeClass('is-active');
        //tab.addClass('is-active');
        //$('#tab-content p').removeClass('is-active');
       // $('p[data-content="' + tab + '"]').addClass('is-active');
      }
    }
  }

</script>
<style lang="scss">
td {
  font-size: 10px;
}
</style>
