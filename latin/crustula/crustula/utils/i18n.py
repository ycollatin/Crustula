from django.utils.translation import gettext as _, gettext_noop as N_, activate
from latin.settings import GETTEXT_LANGUAGES

__all__ = ["_", "N_", "preferred_language"]

def preferred_language(request):
    preferred = "fr"
    accepted = [l[0] for l in
                [ll.split(";") for ll in
                 request.META["HTTP_ACCEPT_LANGUAGE"].split(",")]]
    wanted1 = ""
    for l in accepted:
        if l in GETTEXT_LANGUAGES:
            wanted1 =l
            break
    wanted2 = request.COOKIES.get("preferred_language", "")
    wanted3 = request.GET.get("preferred_language", "")
    if wanted1:
        preferred = wanted1
    if wanted2:
        preferred = wanted2
    if wanted3:
        preferred = wanted3
    activate(preferred)
    return preferred
