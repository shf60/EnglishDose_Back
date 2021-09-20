import { isArray, isBoolean, isObject } from 'lodash';
import React from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import ModalQuestion from './ModalQuestion';

class AnswerRow extends React.Component{
    constructor(props){
        super(props)
        this.handleChange=this.handleChange.bind(this);
        this.handleRemove=this.handleRemove.bind(this);
    }
    handleChange(event){
        const target=event.target;
        target.type === 'checkbox' ? 
        this.props.handleChange({id:this.props.answer.id,answer:this.props.answer.answer,chkbox:target.checked},this.props.answer.id):
        this.props.handleChange({id:this.props.answer.id,answer:target.value,chkbox:this.props.answer.chkbox},this.props.answer.id);
    }
    handleRemove(){
        this.props.handleRemove(this.props.answer.id);
    }
    render(){
        return(
            <div className="input-group" id="answerDiv">
            <input 
                type="checkbox" 
                name="answerOption[]" 
                value={this.props.answer.answer} 
                onChange={this.handleChange} 
                checked={this.props.answer.chkbox} />
            <input 
                type="text" 
                name="answer[]" 
                className="form-control"  
                value={this.props.answer.answer} 
                onChange={this.handleChange} 
                required />
            <div className="input-group-prepend">
            <button type="button" className="btn btn-danger fas fa-trash" onClick={this.handleRemove} /></div>
            </div>
        );
    }
}

class Answers extends React.Component{
    constructor(props){
        super(props)
        this.handleChange=this.handleChange.bind(this);
        this.handleRemove=this.handleRemove.bind(this);
    }
    handleChange(Answer,id){
        let answerList1=this.props.AnswerList;
        answerList1.forEach(element => {
            if (element.id==id){
            element.answer=Answer.answer;
            element.chkbox=Answer.chkbox;
            }
        });
        this.props.handleChange(answerList1);
    }
    handleRemove(id){
        this.props.handleRemove(id);
    }
    render(){
        let rows=[];
        this.props.AnswerList.map(
            (answer)=>rows.push(
            <AnswerRow 
                key={answer.id} 
                answer={answer} 
                handleChange={this.handleChange} 
                handleRemove={this.handleRemove} />
            ));
        return(
            <div>{rows}</div>
        );
    }
    }

class Question extends React.Component{
    constructor(props){
        super(props)
        this.handleChange=this.handleChange.bind(this);
        this.handleKeyPress=this.handleKeyPress.bind(this);
    }
    handleChange(e){
        if(e.target.name==='question'){
            this.props.handleChange(e.target.value)
        }
        else{
        const answer={id:Math.random()*100,answer:e.target.value,chkbox:false};
        this.props.handleChange(answer);
        }
    }
    handleKeyPress(e){
        if(e.key==='Enter'){
            this.props.handleClick();
        }
    }
render(){
    return(
        <div>
            <label htmlFor="question">Question</label>
            <input 
                type="text" 
                className="form-control" 
                name="question" 
                id="question" 
                placeholder="Write your question" 
                onChange={this.handleChange} 
                autoFocus
                required />
            <label htmlFor="answerInput">Add Answer</label>
            <div className="input-group">
                <div className="input-group-prepend">
                <button 
                    type="button" 
                    className="btn btn-success fas fa-plus-square" 
                    onClick={this.props.handleClick} />
                </div>
                <input 
                    type="text" 
                    id="answerInput" 
                    name="answerInput" 
                    value={this.props.Answer.answer} 
                    onKeyPress={this.handleKeyPress}
                    onChange={this.handleChange} 
                    className="form-control" 
                    placeholder="Write your answers" />
            </div>
            <label htmlFor="answers" style={{ marginTop: "5px" }}>Answers</label>
        </div>
            
    );
}
}
export default class CreateQuestion extends React.Component{
    constructor(props){
        super(props)
        this.state={question:'',answer:{id:0,answer:'',chkbox:false},answerList:[]};
        this.handleChange=this.handleChange.bind(this);
        this.handleClick=this.handleClick.bind(this);
        this.handleRemove=this.handleRemove.bind(this);
        this.handleSubmit=this.handleSubmit.bind(this);
    }
    handleChange(value){
        isArray(value) ?
        this.setState({answerList: value}) :
        isObject(value)? 
        this.setState({answer: value}):
        this.setState({question: value});
    }
    handleClick(){
        this.state.answer.answer ?
        this.setState(prevState=>({answerList: [...prevState.answerList,prevState.answer],answer:{id:0,answer:'',chkbox:true?true:false} })):
        alert("It seem's empty!");
    }
    handleRemove(id){
        this.setState(prevState=>({answerList: prevState.answerList.filter((item,i)=>item.id!=id)}));
    }
    handleSubmit(event){
        event.preventDefault();
        const config={headers: {
            'content-type':'application/json'
        }};
        const newQuestion={
            question: this.state.question,
            answers: this.state.answerList
        }
        axios.post('/admin/quiz/index',{newQuestion},config).then((response) => {
            if (response.status===200)
            {
            this.props.handleClose();
            }
        })
        .catch((error)=> {
            if(error.response){
            //    this.errors(error.response.message);              
            }else if (error.request) {
              console.log('error.request');
            } else {
              console.log('Error', error);
            }
            console.log("rejected");
});
    };
    render(){
        return(
            <form onSubmit={this.handleSubmit}>
                <div className="form-group">
                <Question Answer={this.state.answer} handleChange={this.handleChange} handleClick={this.handleClick}/>
                <Answers AnswerList={this.state.answerList} handleChange={this.handleChange} handleRemove={this.handleRemove} />
                <hr id="hr" />
                <input type="submit" value="submit" className="btn btn-success" />
                </div>
            </form>            
        );
    }
}
