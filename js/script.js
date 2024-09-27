$(document).ready(function() {
    // 都道府県のオプションを設定
    const prefectures = ["福島県", "千葉県", "愛媛県", "福岡県"];
    const $prefectureSelect = $('select[name="prefecture"]');

    prefectures.forEach(function(prefecture) {
        $prefectureSelect.append('<option value="' + prefecture + '">' + prefecture + '</option>');
    });

    // 都道府県に紐付くエリア名
    const primaryAreas = {
        "福島県": ["中通り", "浜通り", "会津"],
        "千葉県": ["北東部", "北西部", "南部"],
        "愛媛県": ["東予", "中予", "南予"],
        "福岡県": ["福岡地方", "北九州地方", "筑豊地方", "筑後地方"]
    };

    // 都道府県が選択されたときにエリアを更新
    $('select[name="prefecture"]').on('change', function() {
        const selectedPrefecture = $(this).val();
        const $primaryWxAreaSelect = $('select[name="primary_wxarea"]');
        $primaryWxAreaSelect.empty().append('<option value="">--最寄りエリア--</option>');

        if (primaryAreas[selectedPrefecture]) {
            primaryAreas[selectedPrefecture].forEach(function(area) {
                $primaryWxAreaSelect.append('<option value="' + area + '">' + area + '</option>');
            });
        }
    });
});
