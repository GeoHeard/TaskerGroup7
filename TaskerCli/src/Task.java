
/**
 * 
 * Stores all of the information for the task. Provides a function
 * to load a JPanel for this object into the GUI so that it can be
 * viewed and edited. The JPanel can call ‘updateTask’ to read in 
 * any input information from the GUI and store it in the relevant 
 * variables. After any changes are made, the task can interact 
 * with TaskerCli to call saveChanges.
 * 
 * @author Group 07: kuh1, ...
 * @version 0.1
 * @date 24/11/2015
 */

public class Task {
	//Allows us to communicate with the main program and save changes.
	private TaskerCli tasker;
	
	private String title;
	private String email;
	
	//When the task was created
	//private Date startDate;
	//When the task is expected to be completed
	//private Date completeDate;
	
	private Status status;
	//Each string in this array stores a whole task element.
	private String[] elements;
	/*Each string in this array stores the whole comment for the 
	corresponding task in the other array*/
	private String[] comments;
	
	//TaskPanel taskPanel;
	
	/**
	 * Creates a new task that stores the input arguments, with status as 
	 * 'allocated' and a reference to mainProgram.
	 * @param newName
	 * 			The name of the task
	 * @param newEmail
	 * 			The email of the allocated employee
	 * @param newElements
	 * 			The list of task elements written by the manager
	 * @param newComments
	 * 			The list of task comments that accompany the task elements
	 * @param mainProgram
	 * 			The current instance of TaskerCli
	 */
	public Task(String newName, String newEmail,/* Date start, Date end,*/ String[] newElements, String[] newComments[], TaskerCli mainProgram){
		tasker = mainProgram;
	}
	
	/**
	 * 	Create a new JPanel for this task and load it onto the main
	 *  screen GUI.
	 */
	public void initialiseTaskPanel(){
		
	}
	
	/**
	 * Get rid of the tasks JPanel from the GUI.
	 */
	public void hideTaskPanel(){
		
	}
	
	/**
	 * 
	 * Called by the ‘save changes’ button on the GUI. Saves whatever 
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
		
	}
}
