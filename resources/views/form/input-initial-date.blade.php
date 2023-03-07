<span class="form">
    <input type="text" class="geral" name="data_inicial" id="data_inicial" maxlength="10" value="{{old('data_inicial', Request::get('data_inicial', date('d/m/Y')))}}" size="9" onkeypress="formataData(this, event)">
</span>
