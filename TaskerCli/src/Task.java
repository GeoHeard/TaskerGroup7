import java.awt.Dimension;
import java.awt.Font;
import java.awt.GridLayout;
import java.awt.event.ActionEvent;
import java.io.PrintWriter;

import javax.swing.AbstractAction;
import javax.swing.BorderFactory;
import javax.swing.Box;
import javax.swing.BoxLayout;
import javax.swing.JButton;
import javax.swing.JCheckBox;
import javax.swing.JLabel;
import javax.swing.JPanel;
import javax.swing.JScrollPane;
import javax.swing.JTextArea;

/**
 * 
 * Stores all of the information for the task. Provides a function
 * to load a JPanel for this object into the GUI so that it can be
 * viewed and edited. The JPanel can call �updateTask� to read in 
 * any input information from the GUI and store it in the relevant 
 * variables. After any changes are made, the task can interact 
 * with TaskerCli to call saveChanges.
 * 
 * @author Group 07: kuh1, ...
 * @version 0.2
 * @date 28/11/2015
 */

public class Task {
	//Allows us to communicate with the main program and save changes.
	private TaskerCli tasker;
	
	private int taskID;
	private String title;
	private String email;
	
	//When the task was created
	private String startDate;
	//When the task is expected to be completed
	private String completeDate;
	
	private Status status;
	//Each string in this array stores a whole task element.
	private String[] elements;
	/*Each string in this array stores the whole comment for the 
	corresponding task in the other array*/
	private String[] comments;
	
	//TaskPanel taskPanel;
	
	/**
	 * Creates a new task that stores the input arguments, and a reference to mainProgram.
	 * @param ID
	 * 			The tasks unique ID as found in the database
	 * @param newName
	 * 			The name of the task
	 * @param newEmail
	 * 			The email of the allocated employee
	 * @param newStatus
	 * 			The status of the task
	 *@param start
	 *			The date the task started stored as string
	 *@param end
	 *			The date the task should be completed by stored as a string
	 * @param newElements
	 * 			The list of task elements written by the manager
	 * @param newComments
	 * 			The list of task comments that accompany the task elements
	 * @param mainProgram
	 * 			The current instance of TaskerCli
	 */
	public Task(int ID, String newTitle, String newEmail, Status newStatus, String start, String end, String[] newElements, String[] newComments, TaskerCli mainProgram){
		taskID = ID;
		title = newTitle;
		email = newEmail;
		startDate = start;
		completeDate = end;
		status = newStatus;
		elements = newElements;
		comments = newComments;
		tasker = mainProgram;
	}
	
	/**
	 * 	Create a new JPanel for this task returns it
	 *  @return TaskPanel
	 *  			The panel displaying the info for this task
	 */
	public JPanel initialiseTaskPanel(){
		JPanel thePanel = new TaskPanel(this);
		return thePanel;
	}
	
	/**
	 * 
	 * Called by the �save changes� button on the GUI. Saves whatever 
	 * values are in the input boxes into the corresponding variables, 
	 * it then calls TaskerCli.saveChanges() so that the tasks are 
	 * synchronised.
	 * @param newComments
	 * 			The comments that correspond with each task element,
	 * 			found in the corresponding input boxes below each task
	 * 			element on the GUI.	
	 * @param newStatus
	 * 			The status found in the input box for status.
	 */
	public void updateTask(String[] newComments, Status newStatus){
		comments = newComments;
		status = newStatus;
		tasker.saveChanges();
		
		//NOW WE NEED A WAY TO REFRESH THE JMENU IF A TASK HAS BEEN MARKED COMPLETE
		//ALSO APPLIES TO IF THERE HAS BEEN A SYNCHRONISATION
		//WHAT IF THE CURRENT TASK BEING EDITED IS MARKED AS COMPLETE OR ABANDONED?
	}
	
	/**
	 * 
	 */
	private void cancleChanges(){
		tasker.cancelChanges();
	}
	
	/**
	 * Saves this tasks information using the given print writer.
	 * @param pw
	 * 		An already initialised printWriter so that we can write into the associated file.
	 */
	public void saveInfo(PrintWriter pw){
		//Print the general task information
		pw.println(taskID);
		pw.println(title);
		pw.println(status);
		pw.println(startDate);
		pw.println(completeDate);
		
		//print the number of task elements
		pw.println(elements.length);
		
		//loop and print each task element and comment
		for(int i = 0; i < elements.length; i++){
			pw.println(elements[i]);
			pw.println(comments[i]);
		}
	}
	
	public int getID(){
		return taskID;
	}
	
	public String getTitle(){
		return title;
	}
	
	public Status getStatus(){
		return status;
	}
	
	public String[] getElements(){
		return elements;
	}
	
	public String[] getComments(){
		return comments;
	}
	
	public String getStartDate(){
		return startDate;
	}
	
	public String getEndDate(){
		return completeDate;
	}
	
	/**
	 * if both objects are of type Task and have the same ID
	 * they are seen as equal.
	 */
	@Override public boolean equals(Object other) {
	    boolean result = false;
	    
	    if(other instanceof Task){
	    	if(((Task) other).getID() == taskID){
	    		result = true;
	    	}
	    }
	    return result;
	}
	
	/* *******************************************************************************
	 * 							END OF MAIN CLASS 'Task'				     	 *
	 * 						 START OF INNER CLASS 'TaskPanel'					 *
	 * *******************************************************************************/
	
	
	/**
	 * This class provides a JPanel that displays a single task.
	 * The Jpanel has text boxes for input of comments and a button
	 * for committing a change to a task.
	 * @author kuh1
	 */
	private class TaskPanel extends JPanel{
		private Task task;
		private JCheckBox isComplete;
		//These text input boxes will store the users comments
		private JTextArea[] jComments;
		
		/**
		 * Creates a new task panel
		 * @param theTask
		 * 			The task which needs to be displayed on screen
		 */
		TaskPanel(Task theTask){
			super();
			
			task = theTask;
			
			//Set the layout of the panel and populate it
			setLayout(new BoxLayout(this, BoxLayout.PAGE_AXIS));
			setBorder(BorderFactory.createMatteBorder(20, 20, 20, 20, this.getBackground()));
			populatePanel(task);
			
			//Make sure it is visible
			setVisible(true); 
		}
		
		/**
		 * 
		 * @param theTask
		 */
		private void populatePanel(Task theTask){
			//Add the title
          	JSLabel title = new JSLabel(theTask.getTitle(), "Arial", Font.BOLD, 18);
          	add(title);
          	       	
          	//Add the title
          	JSLabel startDate = new JSLabel("Start Date: " + theTask.getStartDate(), "Arial", Font.PLAIN, 16);
          	add(startDate);
          	
          	//Add the title
          	JSLabel endDate = new JSLabel("Expected Completion Date: " + theTask.getEndDate(), "Arial", Font.PLAIN, 16);
          	add(endDate);
          	
            //Add the list of task elements and task comments after a space
          	add(Box.createRigidArea(new Dimension(0,10)));
          	//Add the sub title
			JSLabel subTitle = new JSLabel("Task Details", "Arial", Font.BOLD, 16);
          	subTitle.setAlignmentX(LEFT_ALIGNMENT);
          	add(subTitle);
          	add(createElementList(theTask));
          	
          	//Add the checkbox asking if the user wants to mark the task as complete after a space
          	add(Box.createRigidArea(new Dimension(0,10)));
          	add(createCompleteBox());
          	
          	//Add the two buttons
          	add(createButtons());
		}
		
		/**
		 * Creates a JPanel attatched to a JScrollPane that contains a list:
		 * JLabel followed by JTextArea for each task element and element comment.
		 * @param theTask
		 * 			The task we want to display the elements/comments ofs
		 * @return
		 * 			A JScrollPane containing the above described JPanel
		 */
		private JScrollPane createElementList(Task theTask){
			//Make a panel with vertical grid layout
			JPanel theList = new JPanel();
			theList.setLayout(new GridLayout(0,1)); 
			
          	//Stores the elements and comments found in the task
			String[] elements = theTask.getElements();
			String[] comments = theTask.getComments();
			
			//An array of labels, one for each element
			JLabel[] jElements = new JLabel[elements.length];
			//An array of input boxes, one for each comment
			jComments = new JTextArea[elements.length];
			
			//Loop for each comment/element
			for(int i = 0; i < elements.length; i ++){
				//Create the JComponents
				jElements[i] = new JLabel();
				jComments[i] = new JTextArea();
				//Set the corresponding text
				jElements[i].setText(elements[i]);
				jComments[i].setText(comments[i]);
				//Add them to the panel
				theList.add(jElements[i]);
				theList.add(jComments[i]);
			}
			
			JScrollPane scrollPane = new JScrollPane(theList);
			scrollPane.setBorder(BorderFactory.createMatteBorder(0, 0, 0, 0, this.getBackground()));
			
			return scrollPane;
		}
		
		/**
		 * Creates a panel with a label and checkbox in line asking if the user
		 * wants to mark the task as completed
		 * @return
		 * 		A panel containing the two components in line
		 */
		private JPanel createCompleteBox(){
			JPanel panel = new JPanel();
			
			//Add the question
          	JSLabel question = new JSLabel("Task Completed?: ", "Arial", Font.PLAIN, 16);
          	panel.add(question);
          	
          	//Add the checkbox
          	isComplete = new JCheckBox();
          	panel.add(isComplete);
			
			return panel;
		}
		
		/**
		 * Creates a panel with two buttons, one to save changes and one to cancel changes.
		 * @return
		 * 		A panel containing the two buttons
		 */
		private JPanel createButtons(){
			JPanel panel = new JPanel();
			
			panel.add(createSaveBtn());
			panel.add(createCancelBtn());
			
			return panel;
		}
		
		 /**
	        * Creates the button the user will press to login
	        * @return 
	        */
	        private JButton createSaveBtn(){
	            //Create a new button and define its behaviour
	        	JButton saveBtn = new JButton(new AbstractAction("Save changes") {
	        		public void actionPerformed(ActionEvent ae) {
	        			//We need to store the information contained on the JPanel
	        			String[] newComments = new String[jComments.length];
	        			Status newStatus = task.getStatus();
	        			
	        			//Loop through each JTextArea
	        			for(int i = 0; i < jComments.length; i++){
	        				//Capture the input
	        				newComments[i] = jComments[i].getText();
	        			}
	        			
	        			if(isComplete.isSelected()){
	        				newStatus = Status.COMPLETED;
	        			}
	        			
	        			task.updateTask(newComments, newStatus);
	        		}
	        	});
	                   
	        	return saveBtn;
	        }
	        
	        /**
	         * Creates the button the user will press to login
	         * @return 
	         */
	         private JButton createCancelBtn(){
	             //Create a new button and define its behaviour
	         	JButton cancleBtn = new JButton(new AbstractAction("Cancel changes") {
	         		public void actionPerformed(ActionEvent ae) {
	         			//Basically could just ask to reload this task panel as it will reset all changes
	         			task.cancleChanges();
	         		}
	         	});
	                    
	         	return cancleBtn;
	         }
	}
}
