import java.io.PrintWriter;
import java.util.Scanner;

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
 * @version 0.2
 * @date 28/11/2015
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
	 * Creates a new task that stores the input arguments, and a reference to mainProgram.
	 * @param newName
	 * 			The name of the task
	 * @param newEmail
	 * 			The email of the allocated employee
	 *@param start
	 *
	 *@param end
	 *
	 * @param newStatus
	 * 			The status of the task
	 * @param newElements
	 * 			The list of task elements written by the manager
	 * @param newComments
	 * 			The list of task comments that accompany the task elements
	 * @param mainProgram
	 * 			The current instance of TaskerCli
	 */
	public Task(String newTitle, String newEmail,/* Date start, Date end,*/ Status newStatus, String[] newElements, String[] newComments, TaskerCli mainProgram){
		title = newTitle;
		email = newEmail;
		//startDate = start;
		//completeDate = end;
		status = newStatus;
		elements = newElements;
		comments = newComments;
		tasker = mainProgram;
	}
	
	/**
	 * 	Create a new JPanel for this task and load it onto the main
	 *  screen GUI.
	 *  
	 *  Currently loads a text interface for the prototype
	 */
	public void initialiseTaskPanel(){
		Scanner in = new Scanner(System.in);
		String choice;
		
		//print task info
		System.out.println("");
		System.out.println("Task: " + title);
		/*Print start date*/
		/*Print completion data*/
		System.out.println("Task status: " + status);
		System.out.println("");
		
		//Print out the task elements and their comments
		for(int i = 0; i < elements.length; i++ ){
			System.out.println("Step " + i + ": " + elements[i]);
			System.out.println("Your comment: " + comments[i]);
		}
		System.out.println("");

		//Give the user options
		choice = "";
		while(!choice.equals("b")){
			System.out.println("Please enter the number of the step you want to edit the comment of, ");
			System.out.println("or 'f' to change task to completed or 'b' to go back to the previous menu: ");
			
			choice = in.nextLine();
			
			//If the choice is one of the comments
			for(int i = 0; i < comments.length; i++){
				if(choice.equals(Integer.toString(i))){
					String newComment;
					
					//Ask them to input a new comment to replace the old
					System.out.println("Please enter a new comment for this step: ");
					newComment = in.nextLine();
					
					//Updaye the task to add this new comment
					comments[i] = newComment;
					updateTask(this.comments, this.status);
					choice = "b";
				}
			}
			
			//If the choice is to mark task as complete
			if(choice.equals("f")){
				updateTask(this.comments, Status.COMPLETE);
				choice = "b";
			}
		}
		
		hideTaskPanel();
		in.close();
	}
	
	/**
	 * Get rid of the tasks JPanel from the GUI.
	 * 
	 * Currently just loads taskerCli text interface for prototype
	 */
	public void hideTaskPanel(){
		tasker.initialiseMainScreen();
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
		comments = newComments;
		status = newStatus;
		tasker.saveChanges();
	}
	
	/**
	 * Saves this tasks information using the given print writer.
	 * @param pw
	 * 		An already initialised printWriter so that we can write into the associated file.
	 */
	public void saveInfo(PrintWriter pw){
		//Print the general task information
		pw.println(title);
		pw.println(status);
		//pw.println(start);
		//pw.println(end);
		
		//print the number of task elements
		pw.println(elements.length);
		//loop and print each task element and comment
		for(int i = 0; i < elements.length; i++){
			pw.println(elements[i]);
			pw.println(comments[i]);
		}
	}
	
	public String getTitle(){
		return title;
	}
	
	public Status getStatus(){
		return status;
	}
}
