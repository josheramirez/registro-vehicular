import logo from './logo.svg';
import './App.css';
import MainHeader from './MainHeader'
import MainSidebar from './MainSidebar'
import ContentWrapper from './ContentWrapper'
import MainFooter from './MainFooter'
import ControlSidebar from './ControlSidebar'
import ContentProfile from './ContentProfile'
function App() {
  return (
    <div className="wrapper">
        <MainHeader/>
        <MainSidebar/>
        {/* <ContentWrapper/> */}
        <ContentProfile/>
        <MainFooter/>
        <ControlSidebar/>

      {/* <header className="App-header">
        <img src={logo} className="App-logo" alt="logo" />
        <p>
          Edit <code>src/App.js</code> and save to reload.
        </p>
        <a
          className="App-link"
          href="https://reactjs.org"
          target="_blank"
          rel="noopener noreferrer"
        >
          Learn React
        </a>
      </header> */}

    </div>
  );
}

export default App;
