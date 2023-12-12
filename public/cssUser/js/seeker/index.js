const options = {
    includeScore: true,
    includeMatches: true,
    useExtendedSearch: false,
    threshold: 0.6,
    keys: [
        { name: "title", weight: 3 },
        { name: "link", weight: 2 },
    ],
};

var allSearchKeywords = data;

clearSearch = () => {
    console.log("clear");
    document.getElementById("textSearch").value = "";
    document.getElementById("results").innerHTML = "";
};

search = () => {
    let text = document.getElementById("textSearch").value;
    const fuse = new Fuse(allSearchKeywords, options);
    const res = fuse.search(text);
    const finalSearchResults = sortByWeight(res, text);
    const resultsElement = document.getElementById("results");
    var html = "";
    if (text.trim()) {
        resultsElement.classList.remove("d-none");
    } else {
        resultsElement.classList.add("d-none");
    }
    if (res.length) {
        resultsElement.classList.remove("d-none");
        html += `<h4 id="header-title"><b>${res.length} search result(s) found</b></h4>`;
        for (let i = 0; i < res.length; i++) {
            html += `
            <div class="searches">
                <a href="${finalSearchResults[i].item.link}" id="border-seeker">${finalSearchResults[i].item.title}</a>
            </div>`;
        }
        document.getElementById("results").innerHTML = html;
    } else {
        document.getElementById("results").innerHTML =
            "<h4 id='header-title'> <b>No result found </b></h4>";
    }
};

sortByWeight = (searchRes, searchKeyword) => {
    searchRes.forEach((element) => {
        element.matches.forEach((match) => {
            if (
                match.key === "keywords.keyword" &&
                (match.value.indexOf(searchKeyword.toLowerCase()) > -1 ||
                    searchKeyword.indexOf(match.value.toLowerCase()) > -1)
            ) {
                element.isMatchKeyword = true;
            }
        });
    });
    searchRes.forEach((element) => {
        if (element.isMatchKeyword) {
            element.item.keywords.forEach((item) => {
                if (
                    item.keyword.toLowerCase().indexOf(searchKeyword.toLowerCase()) >
                    -1 ||
                    searchKeyword.toLowerCase().indexOf(item.keyword.toLowerCase()) > -1
                ) {
                    element.searchKeywordWeight = item.weight;
                }
            });
        }
    });
    searchRes.sort((a, b) => {
        return b.searchKeywordWeight - a.searchKeywordWeight;
    });
    return searchRes;
};

debounce = (cb, interval, immediate) => {
    var timeout;

    return function() {
        var context = this,
            args = arguments;
        var later = function() {
            timeout = null;
            if (!immediate) cb.apply(context, args);
        };

        var callNow = immediate && !timeout;

        clearTimeout(timeout);
        timeout = setTimeout(later, interval);

        if (callNow) cb.apply(context, args);
    };
};

document.getElementById("textSearch").onkeyup = debounce(search, 300);