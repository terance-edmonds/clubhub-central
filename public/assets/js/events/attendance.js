(() => {
    const args = { video: document.getElementById('preview') };

    if (args.video) {
        window.URL.createObjectURL = (stream) => {
            args.video.srcObject = stream;
            return stream;
        };

        let scanner = new Instascan.Scanner(args);

        scanner.addListener('scan', function (content) {
            $('#id').val(content);
            $('button[value="event-attendance-search"]').trigger('click');
        });

        Instascan.Camera.getCameras()
            .then(function (cameras) {
                if (cameras.length > 0) {
                    scanner.start(cameras[0]);
                } else {
                    console.error('No cameras found.');
                }
            })
            .catch(function (e) {
                console.error(e);
            });
    }
})();
