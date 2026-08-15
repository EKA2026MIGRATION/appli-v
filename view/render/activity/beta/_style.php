<style>

    .li-child {
        color: darkred;
    }

    .centerTitle {
        text-align: center;
        font-weight: bold;
        margin: 30px 0px;
        cursor: pointer;
        border-bottom: 1px solid gray;
    }

    #ulPickup {
        display: flex; flex-wrap: wrap;
    }

    #ulPickup > ul {
        min-width: 250px;
        padding: 10px;
        padding-right: 20px;
        border-right: 1px solid lightgrey;
    }

    #ulGroups .ulGroupItem {
        min-width: 250px;
        border: 1px solid darkred;

    }

    #ulPickup li {
        list-style: none;
        margin: 0px; padding: 0px;
        cursor: pointer;
        padding: 10px;

    }
    #ulGroups li {
        list-style: none;
        margin: 0px;
        padding: 0px;
        cursor: pointer;
        padding-left: 4px;
    }
    #ulGroups li:hover {
        background-color: darkblue;
        color: white;
    }


    #ulPickup li {
        display: inline;
    }

    #ulPickup > ul > div {
        color: darkblue; font-weight: bold; text-align: center;
    }

    #ulGroups .ulGroupItem > div {
        color: white; text-align: center;
        background-color: darkred;
        padding: 10px;
    }

    #ulGroups > .timeLine {
        margin-top: 60px;
        width: 100%;
        display: flex;
        justify-content: space-between;
        font-size: 2rem;
        font-weight: bold;
        border-bottom: 1px solid grey
    }
    
    .ulGroupMoment {
        display: flex;
        padding: 20px;
        flex-wrap: wrap;
    }

    .sport_pastille {
        background-color: darkred;
        padding: 4px;
        width: 35px;
        height: 35px;
        color: white;
        font-weight: bold;
        margin: 1px;
        text-align: center;
    }

    #editModalDiv {
        position: absolute; width: 600px; background-color: lightgrey; padding: 20px;
        z-index: 999;
        display: none;
    }

    #editModalDiv div:nth-child(3) {
        text-align: center;
    }

    #editModalChildName{
        font-weight: bold;
        color: darkblue;
        font-size: 1.4rem;
        text-align: center;
    }

    #editModalGroupUl li {
        list-style: none;
    }


    #editModalGroupDiv {
        position: absolute;
        width: 600px;
        padding: 20px;
        z-index: 9999;
        box-shadow: 0px 0px 10px 0px black;
        border-radius: 10px;
        border: 1px solid darkred;
        background-color: whitesmoke;
        display: none;
    }

    .multi-column {
        -webkit-column-count: 2;
        -moz-column-count: 2;
        column-count: 2;
    }



</style>