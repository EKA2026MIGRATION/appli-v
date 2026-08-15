const urlHost = $('#urlHost').val();
const tokenAuth = $("#tokenAuth").val();

class Navigation {

    constructor(screen, elements, templates, bookletData) {

            let currentPageNumber = null;

            currentPageNumber = sessionStorage.getItem('bookletChild_currentPageNumber');

            if (currentPageNumber < 1){
                currentPageNumber = 0; // change to test navigation
            } 

            this.currentPageNumber = currentPageNumber;
            this.elements          = elements;
            this.htmlContent       = [];
            this.templates         = templates;
            this.screen            = screen;
            this.bookletData       = bookletData;


    }   

    startShow() {
        this.showPage(this.currentPageNumber);
        this.keyBoardEvent();
        this.gestureEvent();
        this.addFullScreenFunction();
    }

    showPage(pageNumber) {

        let currentWindowHeight = window.innerHeight;

        this.currentPageNumber = pageNumber;
        sessionStorage.setItem('bookletChild_currentPageNumber', this.currentPageNumber);

        let board = this.elements[pageNumber];

        // retrieve html template
        let htmlContent = this.templates[board.template];

        // inject html
        screen.innerHTML = htmlContent;

        this.injectHtml('bookletNameVar', this.bookletData.bookletName);
        this.injectHtml('dateEvaluationVar', this.bookletData.dateEvaluationFr);

        // inject Data
        if(board.template == "cover") {
            this.injectHtml('childNameVar', this.bookletData.childName);
            this.injectHtml('childAgeVar', this.bookletData.childAge);
   
            this.injectHtml('bookletDescriptionVar', this.bookletData.bookletDescription);
            this.injectHtml('staffFirstnameVar', this.bookletData.staffFirstname);

            this.injectPhoto('childPhotoUrlVar', this.bookletData.childPhotoUrl);
            this.injectPhoto('staffPhotoUrlVar', this.bookletData.staffPhotoUrl);
        }


        if(board.template == "child") {
            this.injectHtml('childNameVar', this.bookletData.childName);
 
            this.injectHtml('guidingEyeVar', this.bookletData.guidingEye);
            this.injectHtml('sportifProfilVar', this.bookletData.sportifProfil);
            this.injectHtml('childHandVar', this.bookletData.childHand);
            this.injectHtml('childFootVar', this.bookletData.childFoot);

            this.injectPhoto('childPhotoUrlVar', this.bookletData.childPhotoUrl);

            this.injectBackground('rightChild', "https://appli-v.net/"+board.backgroundImg);    


            this.createMapNavigation();
        }

        if(board.template == "coach") {


            console.log(board.backgroundImg);
            this.injectHtml('staffFirstnameVar', this.bookletData.staffFirstname);
            this.injectPhoto('staffPhotoUrlVar', this.bookletData.staffPhotoUrl);
            this.injectHtml('coachCommentVar', this.bookletData.comment);
             if(board.backgroundImg !== null) {
                this.injectBackground('backgroundImgVar', "https://appli-v.net/"+board.backgroundImg);    
            }
        }


        if(board.template == "board") {

            this.injectHtml('boardNameVar', board.name);
            this.injectHtml('boardDescriptionVar', board.description);

            if(board.totemImg !== null) {
                this.injectPhoto('totemImgVar', "https://appli-v.net/"+board.totemImg);    
            }

            if(board.backgroundImg !== null) {
                this.injectBackground('backgroundImgVar', "https://appli-v.net/"+board.backgroundImg);    
            }

            let table =  document.querySelector("[data-id='tableAnswer']");

            for(let i = 0; i < board.responses.length; i++) {

                let response = board.responses[i];
                let percent = response.answer.answer*100/response.item.scale;
                let levelCom = "";

                if(percent >= 80) { levelCom = "EXCELLENT";} 
                if(percent >= 60 && percent < 80) { levelCom = "BON";}
                if(percent >= 40 && percent < 60) { levelCom = "EN COURS";}
                if(percent < 40) { levelCom = "PREMIERS PAS";}

                let html = `<tr><td>${response.item.name}</td><td><div>${levelCom}</div></td></tr><td colspan='2'><progress max="100" value="${percent}"></progress></td></tr>`;

                table.innerHTML = table.innerHTML+html;
            }

            // adjust dimension
            let headerHeight = document.querySelector("[data-id='header']").offsetHeight;
            let headerTotem = document.querySelector("[data-id='totemImgVar']").offsetHeight;
            let marginTop = currentWindowHeight - headerHeight - headerTotem -41;
            document.querySelector("[data-id='totemImgVar']").style.marginTop = marginTop+'px';
        }

        this.updateButtonNavigation(board);
    }

    injectHtml(targetId, value) {
        let element = document.querySelector("[data-id='"+targetId+"']");
        if(element !== null) { element.innerHTML = value;}
    }

    injectPhoto(targetId, value) {
        let element = document.querySelector("[data-id='"+targetId+"']");
        if(element !== null) { element.src = value;}
    }

    injectBackground(targetId, value) {
        let element = document.querySelector("[data-id='"+targetId+"']");
        element.style.backgroundImage = "url('"+value+"')";
    }

    updateButtonNavigation(board) {
        
        let nextButton = document.querySelector("[data-id='nextButton']");
        let prevButton = document.querySelector("[data-id='prevButton']");
        let backButton = document.querySelector("[data-id='buttonBack']");

        let nextPage = parseInt(this.currentPageNumber)+1;
        let prevPage = parseInt(this.currentPageNumber)-1;

        let that = this; 

        if(nextPage >= this.elements.length) { nextPage = this.elements.length-1;}
        if(prevPage < 1) { prevPage = 0;}

        this.injectHtml('prevBoardVar', this.elements[prevPage].name);
        this.injectHtml('nextBoardVar', this.elements[nextPage].name);


        if(nextButton !== null) {
            nextButton.addEventListener('click', function() {
                that.showPage(nextPage);
            })
        }

        if(prevButton !== null) {
            prevButton.addEventListener('click', function() {
                that.showPage(prevPage);
            })
        }

        if(backButton !== null) {
             backButton.addEventListener('click', function() {
                 console.log('clic');
                that.showPage(1);
            })
        }     
    }

    keyBoardEvent() {
        document.addEventListener('keydown', (event) => {
            let nameTouch = event.key;

            if(nameTouch == "ArrowRight") {
                let nextPage = parseInt(this.currentPageNumber)+1;
                if(nextPage < this.elements.length) {
                    this.showPage(nextPage);
                }
            }

            if(nameTouch == "ArrowLeft") {
                let prevPage = parseInt(this.currentPageNumber)-1;
                if(prevPage >= 0) {
                    this.showPage(prevPage);
                }
            }
        });
    }

    gestureEvent() {
        
    }

    addFullScreenFunction() {

        if(this.currentPageNumber != "0")
        {
             document.getElementById('buttonFullscreenNavigation').style.display = "block";
            document.getElementById('windowsFullScreen').style.display = "none";
        }


        let modalButtonOpen = document.getElementById('swapToFullScreen');
        let modalButtonClose = document.getElementById('closeModalFullScreen');
        let enterFullscreenIconButton = document.getElementById('enterFullscreenIcon');
        let exitFullScreenIconButton = document.getElementById('exitFullScreenIcon');

        let that = this;

        modalButtonOpen.addEventListener('click', function() {
            that.setToFullScreen();
            document.getElementById('buttonFullscreenNavigation').style.display = "block";
            document.getElementById('windowsFullScreen').style.display = "none";

        });

        modalButtonClose.addEventListener('click', function() {
            document.getElementById('windowsFullScreen').style.display = "none";
            document.getElementById('buttonFullscreenNavigation').style.display = "block";
        });

        enterFullscreenIconButton.addEventListener('click', function() {
            document.getElementById('windowsFullScreen').style.display = "none";
            that.setToFullScreen();
        });
        

    }



    setToFullScreen()
    {
        var targetelement = document.getElementById("mainContent");  
        
        if (targetelement.requestFullscreen)
        {
            targetelement.requestFullscreen();
        } 	  
        if (targetelement.webkitRequestFullscreen)
        {
            targetelement.webkitRequestFullscreen();
        }
        if (targetelement.mozRequestFullScreen)
        {
            targetelement.mozRequestFullScreen();
        }
        if (targetelement.msRequestFullscreen)
        {
            targetelement.msRequestFullscreen();
        }

         if (document.webkitFullscreenElement) {
            document.webkitCancelFullScreen();
        } else {
            const el = document.documentElement;
            el.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
        }
    }


    exitFullScreen()
    {
        var targetelement = document.getElementById("mainContent");  
        
        if (targetelement.requestFullscreen)
        {
            targetelement.exitFullscreen();
        } 	  
        if (targetelement.webkitRequestFullscreen)
        {
            targetelement.webkitExitFullscreen();
        }
        if (targetelement.mozRequestFullScreen)
        {
            targetelement.mozCancelFullScreen();
        }
        if (targetelement.msRequestFullscreen)
        {
            targetelement.msExitFullscreen();
        } 
    }
    
    createMapNavigation() {

        let showMap = 1; 
        let html = "<ul>";
        let j = 1;
        let k = 0;
        for(let i = 2; i < this.elements.length-1; i++) {

            if(this.elements[i].iconImg == null) {
                showMap = 0;
            } else {
                k++;
            }
            html += `<li onclick="goToBoard(${i})"><span>${j}</span> ${this.elements[i].name}</li>`;
            j++;
        }
        html += "<ul>";

        if(showMap == 0) {
            this.showMenu(html);
        } else {
            this.showMap(k);
        }
    }


    showMenu(html) {
        document.getElementById('simpleMenu').innerHTML = html;
        document.getElementById('simpleMenu').style.display = "block";
        document.getElementById('dynamicMap').style.display = "none";
    }

    showMap(nbIcons) {

            nbIcons = parseInt(nbIcons);

            let dynamicMap = document.querySelector("[data-id='dynamicMap']");
            dynamicMap.style.display = "block";
            document.getElementById('simpleMenu').style.display = "none";
            this.injectBackground('rightChild', "none");  


            let totalHeight   = dynamicMap.offsetHeight;
            let totalWidth    = dynamicMap.offsetWidth;
            let iconHeight    = totalHeight/(nbIcons);
            let freeSpaceY    = totalHeight-(nbIcons)*iconHeight;
            let spaceBetweenY = freeSpaceY/(nbIcons-1); 
            let stepY         = iconHeight/1.3;

            let freeSpaceX    = totalWidth-(iconHeight*nbIcons);
            let spaceBetweenX = freeSpaceX/(nbIcons-1);
            let stepX         = iconHeight/1.3;



            let html = "";
            let k = 1;
            let position = 0;

        
            for(let i = 2; i < this.elements.length-1; i++) {

                let top  = position*(spaceBetweenY+stepY);
                let left = position*(spaceBetweenX+stepX); 


                html += `<div class="iconChildMenu" onclick="goToBoard(${i})" style="top: ${top}px; left: ${left}px; width: ${iconHeight+20}px; height: ${iconHeight+20}px">
                            <img style="max-width: ${iconHeight}px; max-height: ${iconHeight}px" src="https://appli-v.net/${this.elements[i].iconImg}"/>
                            <br/><span>${k}</span>
                            ${this.elements[i].name}
                        </div>`;
                position++; k++;

            }
          document.getElementById('dynamicMap').innerHTML = html;



/*
            let canvas = document.getElementById('dynamicMap');
            let ctx = canvas.getContext('2d');

            ctx.beginPath();
            ctx.lineWidth = '8  ';
            ctx.strokeStyle = '#00359438';
            ctx.moveTo(50, 25);
            ctx.arcTo(50, 125, 250, 50, 50);
            ctx.stroke();*/
    }


}