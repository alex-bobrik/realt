<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>


<div class="container">
    <div id="realt"></div>
</div>


<script crossorigin src="https://unpkg.com/react@16/umd/react.development.js"></script>
<script crossorigin src="https://unpkg.com/react-dom@16/umd/react-dom.development.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/babel-standalone/6.25.0/babel.min.js"></script>

<script type="text/babel">

    class House extends React.Component {

        constructor(props) {
            super(props);
            this.state = { houses: [] };
        }

        gettingHouses = async (e) => {
            e.preventDefault();

            const priceFrom = e.target.elements.priceFrom.value;
            const priceTo = e.target.elements.priceTo.value;
            const rooms = e.target.elements.roomsAmount.value;

            await fetch(`houses/search?priceFrom=${priceFrom}&priceTo=${priceTo}&roomsAmount=${rooms}`)
                .then(response => response.json())
                .then(data => {
                    this.setState({ houses: data });
                })
        }

        render() {
            const { houses } = this.state;
            return (
                <div>
                    <Form housesMethod = {this.gettingHouses}/>
                    <div>
                        {houses.map(hit =>
                            <div className="house">
                                <img src={hit.image_link} alt=""/>
                                <p>{hit.title}</p>
                            </div>
                        )}
                    </div>
                </div>

            );
        }
    }

    class Form extends React.Component {
        render() {
            return(
                <form onSubmit={this.props.housesMethod}>
                    <div className="form-group">
                        <label htmlFor="roomsAmount">Rooms</label>
                        <select className="form-control" name="roomsAmount">
                            <option>All</option>
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                        </select>
                    </div>
                    <div className="form-group">
                        <label htmlFor="priceFrom">Price from</label>
                        <input type="number" name="priceFrom" className="form-control" min="0" required/>
                    </div>
                    <div className="form-group">
                        <label htmlFor="priceTo">Price to</label>
                        <input type="number" name="priceTo" className="form-control" min="0" required/>
                    </div>
                        <button className="btn btn-primary">Search</button>
                </form>
            )
        }
    }

    ReactDOM.render(<House />, document.getElementById('realt'));


</script>


</body>
</html>
