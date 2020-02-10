<template>
  <div class="container">
    <div class="columns is-gapless">
      <div class="column">
        <div class="panel is-primary">
          <p class="panel-heading">
            Kas: {{ saldo }}
          </p>
          <!-- styling tabs: https://jsfiddle.net/sol_b/L3wLe6h0/2/ -->
          <!-- styling tabs: https://codepen.io/puerdon/pen/RVeZjP -->
          <tabs>
            <tab name="Overzicht" :selected="true">
              <table class="table">
                <tr v-for="(row, rindex) in dataFields">
                  <td
                    v-for="(col, cindex) in row"
                    :class="{
                      'col--month': cindex === 0,
                      'row--name': rindex === 0,
                      'row--total': rindex === 1
                     }"
                  >
                    {{ getCellValue(col) }}
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
                          <option
                            v-for="(month, index) in months"
                            :selected="isCurrentMonth(index)"
                          >{{ month.charAt(0).toUpperCase() + month.slice(1) }}
                          </option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="field">
                    <label class="label">Bedrag</label>
                    <div class="control">
                      <div class="select is-fullwidth">
                        <select name="amount">
                          <option value="10">€ 10,00</option>
                          <option value="0">€ 0,00</option>
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
      dataFields: {
        type: Array,
        required: false,
        default: () => []
      },
    },
    data() {
      return{
        months: [
          'januari',
          'februari',
          'maart',
          'april',
          'mei',
          'juni',
          'juli',
          'augustus',
          'september',
          'oktober',
          'november',
          'december',
        ],
      };
    } ,
    mounted() {
      console.log(this.dataFields);
    },
    methods: {
      getCellValue: function(val) {
        return val.split(',')[0];
      },
      isCurrentMonth: function(index) {
        const d = new Date();
        return d.getMonth() === index;
      },
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
  &.row {
    &--name {
      font-weight: bold;
    }
    &--total {
      background-color: #eee;
      font-weight: bold;
    }
  }
  &.col {
    &--month {
      font-weight: bold;
    }
  }
}
</style>
