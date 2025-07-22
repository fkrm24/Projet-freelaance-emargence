// Auto-tab pour les dates d'expérience (mois -> année)
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('[id^="experiences_"][id$="_date_debut_mois"], [id^="experiences_"][id$="_date_fin_mois"]').forEach(function(moisInput) {
        let anneeInput = null;
        if (moisInput.id.includes('_date_debut_mois')) {
            anneeInput = document.getElementById(moisInput.id.replace('_mois', '_annee'));
        } else if (moisInput.id.includes('_date_fin_mois')) {
            anneeInput = document.getElementById(moisInput.id.replace('_mois', '_annee'));
        }
        if (moisInput && anneeInput) {
            moisInput.addEventListener('input', function() {
                if (this.value.length === 2) anneeInput.focus();
            });
        }
    });
});
// Pour les expériences ajoutées dynamiquement
window.addEventListener('experience:added', function(e) {
    if (e.detail && typeof e.detail.idx !== 'undefined') {
        ['debut', 'fin'].forEach(function(type) {
            var mois = document.getElementById(`experiences_${e.detail.idx}_date_${type}_mois`);
            var annee = document.getElementById(`experiences_${e.detail.idx}_date_${type}_annee`);
            if (mois && annee) {
                mois.addEventListener('input', function() {
                    if (this.value.length === 2) annee.focus();
                });
            }
        });
    }
});
