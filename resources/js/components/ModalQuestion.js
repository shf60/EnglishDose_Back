import React,{useState} from 'react';
import {render} from 'react-dom';
import {Button,Modal} from 'react-bootstrap';
import CreateQuestion from './CreateQuestion';
import axios from 'axios';
export default function ModalQuestion() {
    const [show, setShow] = useState(false);
  
    const handleClose = () => setShow(false);
    const handleShow = () => setShow(true);

    return (
      <>
        <Button variant="primary" onClick={handleShow} accessKey="c" title="Alt + c">
          Create Question
        </Button>
  
        <Modal show={show} onHide={handleClose}>
          <Modal.Header closeButton>
            <Modal.Title>Create Question</Modal.Title>
          </Modal.Header>
          <Modal.Body><CreateQuestion handleClose={handleClose} /></Modal.Body>
          {/* <Modal.Footer>
            <Button variant="secondary" onClick={handleClose}>
              Close
            </Button>
            <Button variant="primary" onClick={handleClose}>
              Save Changes
            </Button>
          </Modal.Footer> */}
        </Modal>
      </>
    );
  }
    let rootID=document.getElementById('quizGenerator');
    rootID &&
    render(<ModalQuestion />,rootID);