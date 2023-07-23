import ApiService from "./ApiService";
function enableLoading (type, download) {
    if (type === 'pdf') {
        download.map(v => {
            if (v.icon === type) {
                v.loading = true
            }
        })
    }
    if (type === 'xls') {
        download.map(v => {
            if (v.icon === type) {
                v.loading = true
            }
        })
    }
}
function stopLoading (download) {
    download.map(v => {
        v.loading = false
    })
}
function downloadType (type) {
    if (type === 'xls') {
        return 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
    }
    if (type === 'pdf') {
        return 'application/pdf'
    }
}
const DownloadService = {
    download: (route, download, name, type, param) => {
        enableLoading(type, download)
        ApiService.DOWNLOAD(route, param,'',res => {
            stopLoading(download)
            let blob = new Blob([res], {type: downloadType(type)});
            const link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = name;
            link.click();
        });
    },
}
export default DownloadService;
