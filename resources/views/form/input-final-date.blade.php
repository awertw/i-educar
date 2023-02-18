<span class="form">
    <input type="text" class="geral" name="data_final" id="data_final" maxlength="10" value="{{old('data_final', Request::get('data_final', date('d/m/Y')))}}" size="9" onkeypress="formataData(this, event)">
</span>
