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
              <div class="table-holder">
                <table class="table is-fullwidth">
                  <tr v-for="(row, rindex) in dataFields">
                    <td
                      v-for="(col, cindex) in parsedRow(row)"
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
              </div>
            </tab>
            <tab name="Storten">
              <form action="/" method="post">
                <div class="form-holder">
                  <div class="field">
                    <label class="label">Naam</label>
                    <div class="control">
                      <input type="radio" id="radio1" name="name" value="Henk" checked>
                      <label for="radio1">H</label>
                      <input type="radio" id="radio2" name="name"value="Emiel">
                      <label for="radio2">E</label>
                      <input type="radio" id="radio3" name="name" value="Rick">
                      <label for="radio3">R</label>
                      <input type="radio" id="radio4" name="name" value="Martijn">
                      <label for="radio4">M</label>
                      <input type="radio" id="radio5" name="name" value="Gerard">
                      <label for="radio5">S</label>
                    </div>
                  </div>
                  <div class="field">
                    <label class="label">Maand</label>
                    <div class="control">
                      <div class="select is-fullwidth">
                        <select name="month">
                          <option
                            v-for="(month, index) in months"
                            :value="month"
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
      // console.log(this.dataFields);
    },
    computed: {
      maxCols() {
        let max = 0;
        this.dataFields.forEach((row) => max = max < row.length ? row.length : max);
        return max;
      },
    },
    methods: {
      parsedRow(row) {
        let ret = new Array(this.maxCols);
        row.forEach((row, i) => ret[i] = row);
        return ret;
      },
      getCellValue: function(val) {
        return val !== undefined ? val.split(',')[0] : '';
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

.table-holder {
  padding: 0 0 40px 0;
}

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

/*
Hide radio button (the round disc)
we will use just the label to create pushbutton effect
*/
input[type=radio] {
  display:none;
  margin:10px;
}

/*
  Change the look'n'feel of labels (which are adjacent to radiobuttons).
  Add some margin, padding to label
*/
input[type=radio] + label {
  display:inline-block;
  margin:-2px;
  padding: 6px 12px;
  background-color: #e7e7e7;
  border-color: #ddd;
}
/*
 Change background color for label next to checked radio button
 to make it look like highlighted button
*/
input[type=radio]:checked + label {
  background-image: none;
  background-color:#d0d0d0;
}
input[type=radio] {
  display:none;
}

input[type=radio] + label {
  width: 20%;
  display:inline-block;
  margin:-2px;
  padding: 8px 12px;
  margin-bottom: 0;
  font-size: 14px;
  line-height: 20px;
  color: #333;
  text-align: center;
  text-shadow: 0 1px 1px rgba(255,255,255,0.75);
  vertical-align: middle;
  cursor: pointer;
  background-color: #f5f5f5;
  background-image: -moz-linear-gradient(top,#fff,#e6e6e6);
  background-image: -webkit-gradient(linear,0 0,0 100%,from(#fff),to(#e6e6e6));
  background-image: -webkit-linear-gradient(top,#fff,#e6e6e6);
  background-image: -o-linear-gradient(top,#fff,#e6e6e6);
  background-image: linear-gradient(to bottom,#fff,#e6e6e6);
  background-repeat: repeat-x;
  border: 1px solid #ccc;
  border-color: #e6e6e6 #e6e6e6 #bfbfbf;
  border-color: rgba(0,0,0,0.1) rgba(0,0,0,0.1) rgba(0,0,0,0.25);
  border-bottom-color: #b3b3b3;
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffffff',endColorstr='#ffe6e6e6',GradientType=0);
  filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
  -webkit-box-shadow: inset 0 1px 0 rgba(255,255,255,0.2),0 1px 2px rgba(0,0,0,0.05);
  -moz-box-shadow: inset 0 1px 0 rgba(255,255,255,0.2),0 1px 2px rgba(0,0,0,0.05);
  box-shadow: inset 0 1px 0 rgba(255,255,255,0.2),0 1px 2px rgba(0,0,0,0.05);
}

input[type=radio]:checked + label {
  background-image: none;
  outline: 0;
  -webkit-box-shadow: inset 0 2px 4px rgba(0,0,0,0.15),0 1px 2px rgba(0,0,0,0.05);
  -moz-box-shadow: inset 0 2px 4px rgba(0,0,0,0.15),0 1px 2px rgba(0,0,0,0.05);
  box-shadow: inset 0 2px 4px rgba(0,0,0,0.15),0 1px 2px rgba(0,0,0,0.05);
  background-color:#e0e0e0;
}
</style>
